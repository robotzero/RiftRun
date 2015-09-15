<?php
namespace spec\DevHelperBundle\Factories;

use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;

class AliceLoaderFactorySpec extends ObjectBehavior
{
    function let(ObjectManager $entityManager)
    {
        $this->beConstructedWith($entityManager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DevHelperBundle\Factories\AliceLoaderFactory');
    }

    function it_implements_an_interface()
    {
        $this->shouldImplement('DevHelperBundle\Factories\LoaderFactory');
    }

    function it_returns_new_alice_fixtures_instance(ObjectManager $entityManager)
    {
        $result = $this->getLoader();
        $result->shouldHaveType('\Nelmio\Alice\Fixtures');
    }
}