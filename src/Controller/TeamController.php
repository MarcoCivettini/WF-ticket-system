<?php

namespace App\Controller;

use App\Entity\Team;
use App\Helper\ApiResponse;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/team", name="team")
 */
class TeamController extends AbstractController
{
    /**
     * @Route("/", name="teamsRecap")
     */
    public function getAllTeams(TeamRepository $teamRepository): Response
    {
        $teams = $teamRepository->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $response = $serializer->normalize($teams, null, [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'users' => ['id', 'username', 'role']]]);

        return new ApiResponse($response, Response::HTTP_OK);
    }

}
