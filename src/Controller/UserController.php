<?php

namespace App\Controller;

use App\Entity\User;
use App\Helper\ApiResponse;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/user", name="user")
 */
class UserController extends AbstractController
{
    /**
     * Get PM of user
     * @param userId id of user to get team PM
     * @Route("/pm/{userId}", name="userPm", methods = {"GET"})
     */
    public function getUserPm(UserRepository $userRepository, $userId): Response
    {
        $user = $userRepository->find($userId);
        if ($user == null) {
            return new ApiResponse(array('message' => 'User not found'), Response::HTTP_NOT_FOUND);
        }
        $teamLeader = $userRepository->getTeamLeader($user->getTeam());

        $serializer = new Serializer([new ObjectNormalizer()]);
        $response = $serializer->normalize($teamLeader, null, [AbstractNormalizer::ATTRIBUTES => ['id', 'username', 'team' => ['id', 'name']]]);

        return new ApiResponse($response, Response::HTTP_OK);
    }
}
