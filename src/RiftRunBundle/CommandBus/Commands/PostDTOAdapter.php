<?php

namespace RiftRunBundle\CommandBus\Commands;

class PostDTOAdapter implements Adapter
{
    public function transform($data):\Object
    {
        $characterTypes = $data['query']['characterType'];
    }
}