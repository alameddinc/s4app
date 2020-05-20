<?php

namespace App\Controller;

use App\Service\TaskService;
use App\Util\FirstTasks;
use App\Util\SecondTasks;
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
        $response = $taskService->fetchExternalTasks(new SecondTasks());
        $taskService->cleanUp();
        $taskService->createWithExternal($response);

        return new Response("Done");
    }
}
