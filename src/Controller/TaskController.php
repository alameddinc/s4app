<?php

namespace App\Controller;


use App\Entity\Developer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks_information", name="task")
     * @return Response
     */
    public function index()
    {
        $developers = $this->getDoctrine()->getManager()->getRepository(Developer::class);
        return $this->render('task/list.html.twig', [
            'summaries' => $developers->sumAllTaskDurations(),
            'developers' => $developers->findAll()
        ]);

    }
}
