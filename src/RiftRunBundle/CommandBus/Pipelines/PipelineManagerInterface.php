<?php

namespace RiftRunBundle\CommandBus\Pipelines;

use League\Pipeline\PipelineInterface;

interface PipelineManagerInterface
{
    /**
     * @param array $buildCriteria
     * @return PipelineInterface
     * @throws \InvalidArgumentException
     */
    public function build(array $buildCriteria);
}