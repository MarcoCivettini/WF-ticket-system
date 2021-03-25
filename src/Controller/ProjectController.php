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
        return new ApiResponse('Not implemented yet', Response::HTTP_OK);
    }
}
