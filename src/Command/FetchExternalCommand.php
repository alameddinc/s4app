<?php

namespace App\Command;

use App\Service\TaskService;
use App\Util\FirstTasks;
use App\Util\SecondTasks;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;

class FetchExternalCommand extends Command
{
    protected static $defaultName = 'fetch:external';
    private $taskService;
    private $em;

    public function __construct($name = 'fetch:external', EntityManagerInterface $em)
    {
        parent::__construct($name);
        $this->em = $em;
        $this->taskService = new TaskService($em);
    }

    protected function configure()
    {
        $this
            ->setDescription('Fetch external tasks with this command')
            ->addOption('clear', 'c', InputOption::VALUE_NONE, 'Clean Tasks');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $isClear = json_encode($input->getOption('clear'));
        if ($isClear === 'true') {
            $this->cleanUp();
            $output->writeln("Temizlik Yapıldı");
        }
        $tasks = [];
        $externalServerId = $io->choice('Which Remote server do you want to connect to', ['FirstExternal', 'SecondExternal']);
        switch ($externalServerId) {
            case 'FirstExternal':
                $tasks = $this->taskService->fetchExternalTasks(new FirstTasks());
                break;
            case 'SecondExternal':
                $tasks = $this->taskService->fetchExternalTasks(new SecondTasks());
                break;
        }
        $this->taskService->createWithExternal($tasks);
        return 0;
    }


    private function cleanUp()
    {
        $this->taskService->cleanUp();
    }
}
