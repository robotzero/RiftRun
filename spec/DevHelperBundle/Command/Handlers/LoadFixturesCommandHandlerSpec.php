<?php

namespace spec\DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\LoadFixturesInterface;
use DevHelperBundle\Factories\LoaderFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Nelmio\Alice\Fixtures;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\IntrospectableContainerInterface;

class LoadFixturesCommandHandlerSpec extends ObjectBehavior
{
    function let(LoaderFactory $loaderFactory)
    {
        $this->beConstructedWith($loaderFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DevHelperBundle\Command\Handlers\LoadFixturesCommandHandler');
    }

    function it_delegates_to_load_fixtures_command_to_get_the_fixtures(
        LoadFixturesInterface $loadFixtures,
        IntrospectableContainerInterface $container,
        LoaderFactory $loaderFactory,
        Fixtures $nelmioFixturesLoader
    ) {
        $loadFixtures->fixtures()->shouldBeCalledTimes(1);
        $loadFixtures->fixtures()->willReturn(['something/something.yml']);

        $loaderFactory->getLoader()->willReturn($nelmioFixturesLoader);
        $nelmioFixturesLoader->loadFiles(['something/something.yml'])->shouldBeCalledTimes(1);

        $this->handle($loadFixtures);
    }
}
