<?php

namespace spec\DevHelperBundle\Command\Commands;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LoadFixturesSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(['filelocation.yml', 'evenmoarfiles.yml']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DevHelperBundle\Command\Commands\LoadFixtures');
    }

    function it_should_implement_an_interface()
    {
        $this->shouldImplement('DevHelperBundle\Command\Commands\LoadFixturesInterface');
    }

    function it_returns_file_locations_array()
    {
        $this->fixtures()->shouldEqual(['filelocation.yml', 'evenmoarfiles.yml']);
    }
}
