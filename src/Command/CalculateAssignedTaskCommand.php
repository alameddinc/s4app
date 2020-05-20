<?php

namespace App\Command;

use App\Service\AssignService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CalculateAssignedTaskCommand extends Command
{
    protected static $defaultName = 'calculate:assigned';
    private $taskService;
    private $em;

    public function __construct($name = 'calculate:assigned', EntityManagerInterface $em)
    {
        parent::__construct($name);
        $this->em = $em;
        $this->assignService = new AssignService($em);
    }

    protected function configure()
    {
        $this
            ->setDescription('Calculate and assign all task to developers')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->assignService->computeOptimization();
        $io->success('All Task Calculated and Assigned to Developers');

        return 0;
    }
}
