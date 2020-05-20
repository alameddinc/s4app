<?php
/**
 * Created by PhpStorm.
 * User: alameddincelik
 * Date: 20.05.2020
 * Time: 14:34
 */

namespace App\Service;


use App\Entity\AssignedTask;
use App\Entity\Developer;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class AssignService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function computeOptimization()
    {
        $this->cleanUp();
        $developers = $this->em->getRepository(Developer::class)->findAll();
        $totalDeveloperLevel = $this->calculateDeveloperLevel($developers);

        $tasks = $this->em->getRepository(Task::class)->findBy([], ['level' => 'DESC', 'duration' => 'DESC']);
        $totalJobCapacity = $this->calculateTotalCapacity($tasks);


        // Simple Calculation => round($totalJobCapacity / $totalDeveloperLevel)
        $batchSize = $totalJobCapacity / $totalDeveloperLevel;
        $lastWeekDiff = round($batchSize) - $batchSize;
        $developersWorkBatchSize = $batchSize + ($lastWeekDiff / count($developers));

        foreach ($developers as $developer) {
            $developerLevel = $developer->getLevel();
            $developerCapacity = $developersWorkBatchSize * $developerLevel;
            foreach ($tasks as $task) {
                if ($task->neededCapacity <= 0) {
                    continue;
                }

                if ($developerCapacity >= $task->neededCapacity) {
                    $this->assignTask($developer, $task, ($task->neededCapacity / $developerLevel));
                    $developerCapacity -= $task->neededCapacity;
                    $task->neededCapacity = 0;
                } else {
                    // task add 2
                    $this->assignTask($developer, $task, ($developerCapacity / $developerLevel));
                    $task->neededCapacity = $developerCapacity;
                    $developerCapacity = 0;
                    break;
                }

            }
        }
        $this->em->flush();
    }

    /**
     * @param $developers
     * @return int
     */
    private function calculateDeveloperLevel($developers)
    {
        $count = 0;
        foreach ($developers as $developer) {
            $count += $developer->getLevel();
        }
        return $count;
    }

    /**
     * @param $tasks
     * @return int
     */
    private function calculateTotalCapacity($tasks)
    {
        $count = 0;
        foreach ($tasks as $task) {
            $task->neededCapacity = $task->getDuration() * $task->getLevel();
            $count += $task->neededCapacity;
        }
        return $count;
    }

    public function cleanUp()
    {
        $taskRepository = $this->em->getRepository(AssignedTask::class);
        $entities = $taskRepository->findAll();
        foreach ($entities as $entity) {
            $this->em->remove($entity);
        }
        $this->em->flush();
    }

    private function assignTask($developer, $task, $duration)
    {
        $assignedTask = new AssignedTask();
        $assignedTask->setDeveloper($developer)
            ->setTask($task)
            ->setDuration($duration);
        $this->em->persist($assignedTask);
    }


}