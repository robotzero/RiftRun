<?php

namespace spec\DevHelperBundle\Database;

use DevHelperBundle\Command\AliceFixtureLoader;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SeederSpec extends ObjectBehavior
{
    private $aliceFixtureLoader;

    function let(AliceFixtureLoader $aliceFixtureLoader, EntityManagerInterface $entityManager)
    {
        $this->beConstructedWith($aliceFixtureLoader, $entityManager, true);
        $this->aliceFixtureLoader = $aliceFixtureLoader;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DevHelperBundle\Database\Seeder');
    }

    function it_sets_fixtures_on_aliceloader(AliceFixtureLoader $aliceFixtureLoader)
    {
        $this->loadFixtures([]);
        $aliceFixtureLoader->setFixtures([])->shouldBeCalled();
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
