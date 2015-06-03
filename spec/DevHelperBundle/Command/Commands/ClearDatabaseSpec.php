<?php

namespace spec\DevHelperBundle\Command\Commands;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClearDatabaseSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('DevHelperBundle\Command\Commands\ClearDatabase');
    }
}
