<?php

namespace App\Controller;


use App\Entity\Developer;
use App\Service\AssignService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task")
     * @return Response
     */
    public function index(AssignService $assignService)
    {
        /*
         $entityManager = $this->getDoctrine()->getManager();
        $developerNames = [
            'Ali',
            'Ayşe',
            'Kemal',
            'Cengiz',
            'Alameddin',
        ];
        for ($i = 1; $i<=5; $i++){
          $dev  = new Developer();
          $dev->setFullName($developerNames[$i-1]);
          $dev->setLevel($i);
          $entityManager->persist($dev);
        }

        $entityManager->flush();
        $entityManager->clear();

        return new Response("Done");
        */
        dd($assignService->computeOptimization());
    }
}
