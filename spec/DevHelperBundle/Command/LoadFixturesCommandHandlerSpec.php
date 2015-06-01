<?php

namespace spec\DevHelperBundle\Command;

use DevHelperBundle\Command\AliceFixtureLoader;
use DevHelperBundle\Command\LoadFixtures;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LoadFixturesCommandHandlerSpec extends ObjectBehavior
{
    private $entityManager;

    function let(EntityManagerInterface $entityManager)
    {
        $this->beConstructedWith($entityManager);
        $this->entityManager = $entityManager;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DevHelperBundle\Command\LoadFixturesCommandHandler');
    }

    function it_sets_fixtures_on_aliceloader(LoadFixtures $loadFixtures)
    {
        $this->handle($loadFixtures);
        //$aliceFixtureLoader->setFixtures([])->shouldBeCalled();
    }

    function it_calls_load_on_aliceloader(AliceFixtureLoader $aliceFixtureLoader, EntityManagerInterface $entityManager)
    {
        $this->loadFixtures([]);
        $aliceFixtureLoader->load($entityManager)->shouldHaveBeenCalled();
    }

    function it_returns_collection_of_fixtures(AliceFixtureLoader $aliceFixtureLoader)
    {
        $this->loadFixtures(['something something'])->shouldHaveType('array');
        $aliceFixtureLoader->load()->willReturn([new \StdClass()]);
    }
}
