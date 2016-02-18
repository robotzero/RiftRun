<?php

namespace RiftRunBundle\CommandBus\Commands;

use RiftRunBundle\DTO\DTO;

interface Adapter
{
    public function getDTO():DTO;
}