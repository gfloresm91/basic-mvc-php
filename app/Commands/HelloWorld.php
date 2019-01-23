<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class HelloWorld extends Command
{
    protected static $defaultName = 'app:hello-world';

    public function configure()
    {
        $this
            ->addArgument(
                'name', 
                InputArgument::REQUIRED, 
                'Example argument command'
            );
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello '. $input->getArgument('name'));
    }
}
