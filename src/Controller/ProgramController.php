<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProgramRepository;
use App\Form\ProgramType;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;

class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs,
         ]);
    }

    #[Route('/program/list/{page}', requirements: ['page'=>'\d+'], name: 'program_list')]
    public function list(int $page = 1): Response
    {
        return $this->render('program/list.html.twig', ['page' => $page]);
    }

    #[Route('/show/{id<^[0-9]+$>}', name: 'program_show')]
    public function show(Program $program):Response
{

        if (!$program) {
            throw $this->createNotFoundException(
                'No program found.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/program/{program}/seasons/{season}', name: 'program_season_show')]
    public function showSeason(Program $program, Season  $season):Response
    {
        $episodes = $season->getEpisodes();
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes,
        ]);

    }

    #[Route('/program/{program}/season/{season}/episode/{episode}', name: 'program_episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode):Response
    {
        $episodes = $season->getEpisodes();
        return $this->render('/program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes,
            'episode' => $episode,
        ]);

    }

    #[Route('/program/new', name: 'new_program')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        $program = new Program();
        // Create the form, linked with $category
        $form = $this->createForm(ProgramType::class, $program);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            $programRepository->save($program, true);
        }
        // Render the form (best practice)
        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
            'programs' => $programs,
        ]);
        // Alternative
        // return $this->render('category/new.html.twig', [
        //   'form' => $form->createView(),
        // ]);

    }
}
