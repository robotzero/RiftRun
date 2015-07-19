<?php

namespace spec\DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\LoadFixturesInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Hautelook\AliceBundle\Alice\Loader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\IntrospectableContainerInterface;

class LoadFixturesCommandHandlerSpec extends ObjectBehavior
{
    function let(ObjectManager $entityManager)
    {
        $this->beConstructedWith($entityManager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DevHelperBundle\Command\Handlers\LoadFixturesCommandHandler');
    }

    function it_delegates_to_load_fixtures_command_to_get_the_fixtures(
        LoadFixturesInterface $loadFixtures,
        IntrospectableContainerInterface $container,
        Loader $loader
    ) {
        $loadFixtures->fixtures()->shouldBeCalledTimes(1);
        $loadFixtures->fixtures()->willReturn(['something/something.yml']);

        // Ugly hack.
        try {
            $this->handle($loadFixtures);
        } catch (\Exception $e) {

        }
    }
}
