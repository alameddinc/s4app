<?php

namespace App\Controller;

use App\Service\TaskService;
use App\Util\FirstTasks;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task")
     * @param TaskService $taskService
     * @return Response
     */
    public function index(TaskService $taskService)
    {
        $response = $taskService->saveExternalTasks(new FirstTasks());
        return new Response(json_encode($response));
    }
}
