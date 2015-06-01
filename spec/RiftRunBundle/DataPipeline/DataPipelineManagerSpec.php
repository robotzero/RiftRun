<?php

namespace spec\RiftRunBundle\DataPipeline;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DataPipelineManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('RiftRunBundle\DataPipeline\DataPipelineManagerInterface');
    }
}
