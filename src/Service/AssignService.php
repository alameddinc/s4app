<?php
/**
 * Created by PhpStorm.
 * User: alameddincelik
 * Date: 20.05.2020
 * Time: 14:34
 */

namespace App\Service;


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

    public function computeOptimization(){
        $developers = $this->em->getRepository(Developer::class)->findAll();
        $tasks = $this->em->getRepository(Task::class)->findBy([],['level'=>'DESC','duration'=>'DESC']);
        $totalJobCount=0;
        $totalDeveloperLevel = 0;
        foreach ($tasks as $task){
            $task->count = $task->getDuration() * $task->getLevel();
            $totalJobCount += $task->count;
        }
        foreach ($developers as $developer){
            $totalDeveloperLevel += $developer->getLevel();
        }
        $developerWorkBatchSize = round($totalJobCount / $totalDeveloperLevel);
        foreach ($developers as $developer){
            $developerCapacity = $developerWorkBatchSize * $developer['level'];
            $tempJobs = [];
            foreach ($tasks as $task){
                if($task->count <= 0){
                    continue;
                }
                if($developerCapacity >= $task->count){
                    // task add 1
                    $developerCapacity -= $task->count;
                    array_push($tempJobs, $task);
                    $task->count = 0;
                }else{
                    // task add 2
                    $task->count = $developerCapacity;
                    array_push($tempJobs, $task);
                    break;
                }
            }
        }
    }


}