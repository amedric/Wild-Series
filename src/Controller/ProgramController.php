<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProgramRepository;
use App\Form\ProgramType;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;

class ProgramController extends AbstractController
{
    #[Route('/program_index/', name: 'app_program_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs,
         ]);
    }

    #[Route('/program/', name: 'program_list')]
    public function list(ProgramRepository $programRepository): Response
    {
        return $this->render('program/list.html.twig', [
            'programs' => $programRepository->findAll(),
        ]);
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

    #[Route('/programShow/{id<^[0-9]+$>}', name: 'app_program_show',methods: ['GET'])]
    public function programShow(Program $program):Response
    {

        if (!$program) {
            throw $this->createNotFoundException(
                'No program found.'
            );
        }

        return $this->render('program/programShow.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/program/new', name: 'new_program')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program); // Create the form, linked with $category
        $form->handleRequest($request); // Get data from HTTP request

        if ($form->isSubmitted() && $form->isValid()) { // Was the form submitted ?
            $programRepository->save($program, true);
            $this->addFlash('success', 'The new program has been created');
            return $this->redirectToRoute('program_index');
        }
        // Render the form (best practice)
        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
            'programs' => $programs,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_program_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Program $program, ProgramRepository $programRepository): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->save($program, true);
            $this->addFlash('success', 'The program has been updated successfully');
            return $this->redirectToRoute('app_program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('program/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_program_delete', methods: ['POST'])]
    public function delete(Request $request, Program $program, ProgramRepository $programRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$program->getId(), $request->request->get('_token'))) {
            $programRepository->remove($program, true);
            $this->addFlash('danger', 'Program has been deleted');
        }

        return $this->redirectToRoute('app_program_index', [], Response::HTTP_SEE_OTHER);
    }

}
