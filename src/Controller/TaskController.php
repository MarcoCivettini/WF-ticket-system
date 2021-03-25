<?php

namespace App\Controller;

use App\Helper\ApiResponse;
use App\Model\UserRole;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Criteria;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/task", name="task")
 */
class TaskController extends AbstractController
{
    /**
     * Assign task to Developer user
     * @param taskId id of task to link with the user
     * @param request json body of put method that contains the userId to link with the task 
     * @Route("/assign/{taskId}", name="assignTo", methods = {"PUT"}, defaults={"taskId"=null})
     */
    public function giveTaskToUser(Request $request, int $taskId, UserRepository $userRepository, TaskRepository $taskRepository): Response
    {
        $body = $request->toArray();
        try {
            $userId = $body["userId"];
        } catch (Exception $e) {
            return new ApiResponse(array('message' => 'Body not valid'), Response::HTTP_BAD_REQUEST);
        }

        $user = $userRepository->findOneBy(array('id' => $userId, 'role' => UserRole::DEV));
        if ($user == null) {
            return new ApiResponse(array('message' => 'User not found'), Response::HTTP_NOT_FOUND);
        }

        $task = $taskRepository->find($taskId);
        if ($task == null) {
            return new ApiResponse(array('message' => 'Task not found'), Response::HTTP_NOT_FOUND);
        }

        $taskExistcriteria = Criteria::create()->where(Criteria::expr()->eq('id', $task->getId()));
        $taskJustAssociated = $user->getTasks()->matching($taskExistcriteria);
        if ($taskJustAssociated->count() > 0) {
            return new ApiResponse(array('message' => 'User just associated to the task'), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $user->addTask($task);
        $em->persist($user);
        $em->flush();

        return new ApiResponse(null, Response::HTTP_OK);
    }

    /**
     * Remove task from user
     * @param userId id of user where remove the task
     * @param taskId id task to remove from user 
     * @Route("/remove/{userId}/{taskId}", name="removeTask", methods = {"DELETE"})
     */
    public function removeTaskFromUser(int $userId, int $taskId, UserRepository $userRepository, TaskRepository $taskRepository): Response
    {

        $user = $userRepository->find($userId);
        if ($user == null) {
            return new ApiResponse(array('message' => 'User not found'), Response::HTTP_NOT_FOUND);
        }

        $taskExistcriteria = Criteria::create()->where(Criteria::expr()->eq('id', $taskId));
        $taskAssociatedToUser = $user->getTasks()->matching($taskExistcriteria);

        if ($taskAssociatedToUser->count() == 0) {
            return new ApiResponse(array('message' => 'Task isn\'t associated to user'), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $user->removeTask($taskAssociatedToUser[0]);
        $em->persist($user);
        $em->flush();

        return new ApiResponse(null, Response::HTTP_OK);
    }

    /**
     * Remove task from user
     * @param userId id of user where remove the task
     * @param taskId id task to remove from user 
     * @Route("/user/{userId}", name="activeTask", methods = {"GET"})
     */
    public function getUserActiveTask(UserRepository $userRepository, $userId): Response
    {
        $user = $userRepository->find($userId);
        if ($user == null) {
            return new ApiResponse(array('message' => 'User not found'), Response::HTTP_NOT_FOUND);
        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $data = $serializer->normalize($user->getActivedTask(), null, [AbstractNormalizer::ATTRIBUTES => ['id', 'description', 'deadlineDate']]);

        return new ApiResponse($data, Response::HTTP_OK);
    }
}
