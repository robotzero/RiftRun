<?php

namespace DevHelperBundle\Command;

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
        $seeder = $this->getContainer()->get('database_seeder');

        if (is_array($fileLocations) === false) {
            $fileLocations = [$fileLocations];
        }

        try {
            $loadFixtures = $seeder->loadFixtures($fileLocations);
        } catch (\Exception $e){
            echo $e->getMessage();
        }
    }
}
