<?php

namespace App\Controller;

use App\Entity\Team;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        // Serialize your object in Json
        $jsonObject = $serializer->serialize($teams, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        // For instance, return a Response with encoded Json
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
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

        return $this->json('');
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
