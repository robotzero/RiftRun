<?php

namespace DevHelperBundle\Cli;

use DevHelperBundle\Command\Commands\ClearDatabase;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseClearCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('riftrun:database:clear')
             ->setDescription('Clear database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commandBus = $this->getContainer()->get('command_bus');

        try {
            $commandBus->handle(new ClearDatabase());
        } catch (\Exception $e){
            echo $e->getMessage();
        }
    }
}
