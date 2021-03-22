<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/user", name="user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param UserRepository $userRepository
     */
    public function index(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();

        return $this->json($users);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     */
    public function create(Request $request): JsonResponse
    {
        $user = new User();

        $user->setUsername('marco');
        $user->setPassword('marco');

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new JsonResponse('', 200);
    }

    /**
     * @Route("/{id}", name="userDetail")
     * @param Request $request
     */
    public function userDetail($id, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);
        return $this->json($user);
    }
}
