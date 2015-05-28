<?php

namespace spec\DevHelperBundle\Database;

use DevHelperBundle\Command\AliceFixtureLoader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SeederSpec extends ObjectBehavior
{
    function let(AliceFixtureLoader $aliceFixtureLoader)
    {
        $this->beConstructedWith($aliceFixtureLoader, true);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DevHelperBundle\Database\Seeder');
    }
}
