<?php

namespace App\Controller;

use App\Entity\Team;
use App\Helper\ApiResponse;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/team", name="team")
 */
class TeamController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(TeamRepository $teamRepository): Response
    {
        $teams = $teamRepository->findAll();

        return new ApiResponse($teams, Response::HTTP_OK);
    }
    /**
     * @Route("/create", name="create")
     */
    public function create(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $team = new Team();
        $team->setName('Team1');

        $em->persist($team);
        $em->flush();

        return new ApiResponse(null, Response::HTTP_OK);
    }

    /**
     * @Route("/add/{team_id}/{user_id}", name="addMember")
     */
    public function addMember(int $team_id, int $user_id, TeamRepository $teamRepository, UserRepository $userRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $team = $teamRepository->find($team_id);
        $user = $userRepository->find($user_id);
        $team->addUser($user);

        $em->persist($team);
        $em->persist($user);
        $em->flush();
        return $this->json('');
    }
}
