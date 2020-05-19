<?php

namespace App\Service;

use App\Util\TaskInterface;

class TaskService
{
    public function saveExternalTasks(TaskInterface $task)
    {
        return $task->getResponse();
    }
}