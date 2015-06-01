<?php

namespace RiftRunBundle\DataPipeline;

interface DataPipelineManagerInterface
{
    public function onList();

    public function onSingle();
}
