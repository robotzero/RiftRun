<?php

namespace DevHelperBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseSeederCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('riftrun:database:seed');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fixtureLoader = $this->getContainer()->get('alice_fixture_loader');
        $entityManager = $this->getContainer()->get('doctrine')->getManager();
        $rootDir = $this->getContainer()->getParameter('kernel.root_dir');

        $fixtures = ['riftrun' => $rootDir . '/../test/Fixtures/DatabaseSeeder/wizards.yml'];
        $fixtureLoader->setFixtures($fixtures);
        $fixtureLoader->load($entityManager);
    }
}
