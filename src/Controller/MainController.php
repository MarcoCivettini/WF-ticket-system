<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\Team;
use App\Entity\User;
use App\Helper\ApiResponse;
use App\Model\TaskStatus;
use App\Model\UserRole;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
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

        $projects = $this->createProjects($userRepository);
        foreach ($projects as $project) {
            $em->persist($project);
        }
        $em->flush();

        $tasks = $this->createTasks($userRepository);
        foreach ($tasks as $task) {
            $em->persist($task);
        }
        $em->flush();

        return new ApiResponse(null, Response::HTTP_OK);
        // return new Response('Hello wolr');
    }

    /**
     * Create list of users to populate database
     * 1 CEO
     * 2 PM
     * 2 DEV
     */
    private function createUsers(): ArrayCollection
    {
        $userCeo = new User();
        $userCeo->setUsername('Mario')->setPassword('password')->setRole(UserRole::CEO);
        $userPm1 = new User();
        $userPm1->setUsername('Enrico')->setPassword('password')->setRole(UserRole::PM);
        $userPm2 = new User();
        $userPm2->setUsername('Antonio')->setPassword('password')->setRole(UserRole::PM);
        $userDev1 = new User();
        $userDev1->setUsername('Luca')->setPassword('password')->setRole(UserRole::DEV);
        $userDev2 = new User();
        $userDev2->setUsername('Mirco')->setPassword('password')->setRole(UserRole::DEV);
        $users = new ArrayCollection();
        $users->add($userCeo);
        $users->add($userPm1);
        $users->add($userPm2);
        $users->add($userDev1);
        $users->add($userDev2);

        return $users;
    }

    private function createTeams(UserRepository $userRepository): ArrayCollection
    {
        $teams = new ArrayCollection();
        // populate team 1 
        $team1 = new Team();
        $team1->setName('Team 1');
        $pmUser1 = $userRepository->findOneBy(array('username' => 'Enrico', 'role' => UserRole::PM));
        if ($pmUser1->getId()) {
            $team1->addUser($pmUser1);
        }
        $devUser1 = $userRepository->findOneBy(array('username' => 'Luca', 'role' => UserRole::DEV));
        if ($devUser1->getId()) {
            $team1->addUser($devUser1);
        }

        // populate team 2
        $team2 = new Team();
        $team2->setName('Team 2');
        $pmUser2 = $userRepository->findOneBy(array('username' => 'Antonio', 'role' => UserRole::PM));
        if ($pmUser2->getId()) {
            $team2->addUser($pmUser2);
        }
        $devUser2 = $userRepository->findOneBy(array('username' => 'Mirco', 'role' => UserRole::DEV));
        if ($devUser2->getId()) {
            $team2->addUser($devUser2);
        }

        $teams->add($team1);
        $teams->add($team2);

        return $teams;
    }

    private function createProjects(UserRepository $userRepository): ArrayCollection
    {
        $projects = new ArrayCollection();
        $project1 = new Project();
        $project1->setName('Project 1');
        $pmUser = $userRepository->findOneBy(array('username' => 'Antonio', 'role' => UserRole::PM));
        if ($pmUser->getId()) {
            $project1->setUser($pmUser);
        }
        $project2 = new Project();
        $project2->setName('Project 2');
        $pmUser = $userRepository->findOneBy(array('username' => 'Enrico', 'role' => UserRole::PM));
        if ($pmUser->getId()) {
            $project2->setUser($pmUser);
        }

        $projects->add($project1);
        $projects->add($project2);

        return $projects;
    }

    private function createTasks(UserRepository $userRepository): ArrayCollection
    {
        $tasks = new ArrayCollection();

        $task1 = new Task();
        $task1->setDescription('Implement realtime chat with socket');
        $nextWeekDate = new DateTime();
        $nextWeekDate->setISODate($nextWeekDate->format('o'), $nextWeekDate->format('W') + 1);
        $task1->setDeadlineDate($nextWeekDate)->setStatus(TaskStatus::OnWorking);
        $criteriaTask1Devs = Criteria::create()->Where(Criteria::expr()->eq('username', 'Luca'))->orWhere(Criteria::expr()->eq('username', 'Mirco'));
        $users = $userRepository->matching($criteriaTask1Devs);
        foreach ($users as $user) {
            $task1->addUser($user);
        }
        $tasks->add($task1);
        return $tasks;
    }
}
