<?php

namespace spec\DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\LoadFixturesInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Hautelook\AliceBundle\Alice\Loader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\IntrospectableContainerInterface;

class LoadFixturesCommandHandlerSpec extends ObjectBehavior
{
    function let(EntityManagerInterface $entityManager)
    {
        $this->beConstructedWith($entityManager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DevHelperBundle\Command\Handlers\LoadFixturesCommandHandler');
    }

    function it_delegates_to_load_fixtures_command_to_get_the_fixtures(LoadFixturesInterface $loadFixtures, IntrospectableContainerInterface $container, Loader $loader)
    {
        $this->setContainer($container);
        $container->get('hautelook_alice.loader')->willReturn($loader);
        $loadFixtures->fixtures()->shouldBeCalledTimes(1);
        $loadFixtures->fixtures()->willReturn(['array of fixtures']);

        $this->handle($loadFixtures);
    }

    function it_will_throw_an_exception_when_fixtures_are_null(LoadFixturesInterface $loadFixtures, IntrospectableContainerInterface $container, Loader $loader)
    {
        $this->shouldThrow('Symfony\Component\DependencyInjection\Exception\InvalidArgumentException');
        $this->setContainer($container);
        $container->get('hautelook_alice.loader')->willReturn($loader);
        $loadFixtures->fixtures()->willReturn(null);

        $this->handle($loadFixtures);
    }
}
