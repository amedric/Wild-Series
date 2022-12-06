<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
//use App\Repository\SeasonRepository;
//use App\Repository\EpisodeRepository;
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
        return $this->render('/program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);

    }
}

//#[Route('/program/{programId}/seasons/{seasonId}', name: 'program_season_show')]
////    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository, EpisodeRepository $episodeRepository): Response
//    public function showSeason(Program $program, Season  $season)
//{
//    $program = $programRepository->findOneBy(['id' => $programId]);
//    $season = $seasonRepository->findOneby(['id' => $seasonId],);
//    $episodes = $season->getEpisodes();
//
//    return $this->render('program/season_show.html.twig', [
//        'program' => $program,
//        'season' => $season,
//        'episodes' => $episodes,
//    ]);
//
//}
//}
