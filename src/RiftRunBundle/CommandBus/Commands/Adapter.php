<?php

namespace RiftRunBundle\CommandBus\Commands;

interface Adapter
{
    public function transform($data):\Object;
}