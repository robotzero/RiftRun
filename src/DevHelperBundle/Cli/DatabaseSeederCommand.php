<?php

namespace DevHelperBundle\Cli;

use DevHelperBundle\Command\Commands\LoadFixtures;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseSeederCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('riftrun:database:seed')
             ->setDescription('Location of the fixtures.')
             ->addArgument(
             'filelocations',
             InputArgument::IS_ARRAY
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileLocations = $input->getArgument('filelocations');

        if (is_array($fileLocations) === false) {
            $fileLocations = [$fileLocations];
        }

        $commandBus = $this->getContainer()->get('command_bus');

        try {
            $objects = $commandBus->handle(new LoadFixtures($fileLocations));
        } catch (\Exception $e){
            echo $e->getMessage();
        }
    }
}
