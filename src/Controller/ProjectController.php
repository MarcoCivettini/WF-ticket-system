<?php

namespace App\Controller;

use App\Helper\ApiResponse;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/project", name="project")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/cross-team", name="crossTeam")
     */
    public function getProjectCrossTeam(ProjectRepository $projectRepository): Response
    {
        $crossTeams = new ArrayCollection();
        $projects = $projectRepository->findALl();
        foreach ($projects as $project) {
            $tasks = $project->getTasks();
            foreach ($tasks as $task) {
                return new ApiResponse($task->getUsers(), Response::HTTP_OK);
            }
        }
    }
}
