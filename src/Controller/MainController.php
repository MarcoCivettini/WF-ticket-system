<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Helper\ApiResponse;
use App\Model\UserRole;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index(): Response
    {
        return $this->json(["message", "prova"]);
    }

    /**
     * @Route("/seeding", name="seeding")
     */
    public function tempSeeding(UserRepository $userRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        // insert basic users
        $users = $this->createUsers();
        foreach ($users as $user) {
            $em->persist($user);
        }
        $em->flush();

        $teams = $this->createTeams($userRepository);
        foreach ($teams as $team) {
            $em->persist($team);
        }

        $em->flush();

        return new ApiResponse(null, Response::HTTP_OK);
        // return new Response('Hello wolr');
    }

    private function createUsers(): ArrayCollection
    {
        $userCeo = new User();
        $userCeo->setUsername('Mario')->setPassword('password')->setRole(UserRole::CEO);
        $userPm = new User();
        $userPm->setUsername('Antonio')->setPassword('password')->setRole(UserRole::PM);
        $userDev1 = new User();
        $userDev1->setUsername('Luca')->setPassword('password')->setRole(UserRole::DEV);
        $userDev2 = new User();
        $userDev2->setUsername('Mirco')->setPassword('password')->setRole(UserRole::DEV);
        $users = new ArrayCollection();
        $users->add($userCeo);
        $users->add($userPm);
        $users->add($userDev1);
        $users->add($userDev2);

        return $users;
    }

    private function createTeams(UserRepository $userRepository): ArrayCollection
    {
        $teams = new ArrayCollection();
        $team1 = new Team();
        $team1->setName('Team 1');
        $devUser1 = $userRepository->findOneBy(array('username' => 'Luca'));
        if ($devUser1->getId()) {
            $team1->addUser($devUser1);
        }

        $team2 = new Team();
        $team2->setName('Team 2');
        $devUser2 = $userRepository->findOneBy(array('username' => 'Mirco'));
        if ($devUser2->getId()) {
            $team2->addUser($devUser2);
        }

        $teams->add($team1);
        $teams->add($team2);

        return $teams;
    }
}
