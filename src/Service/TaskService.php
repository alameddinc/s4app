<?php

namespace App\Service;

use App\Entity\Task;
use App\Util\TaskInterface;
use Doctrine\ORM\EntityManagerInterface;

class TaskService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function fetchExternalTasks(TaskInterface $task)
    {
        return $task->getResponse();
    }

    public function createWithExternal($items)
    {
        foreach ($items as $item) {
            $task = new Task($item);
            $task->setTitle($item['title']);
            $task->setDuration($item['duration']);
            $task->setLevel($item['level']);
            $this->em->persist($task);
        }

        $this->em->flush();
        $this->em->clear();
    }

    public function cleanUp()
    {
        $taskRepository = $this->em->getRepository(Task::class);
        $entities = $taskRepository->findAll();
        foreach ($entities as $entity) {
            $this->em->remove($entity);
        }
        $this->em->flush();
    }
}