<?php

namespace RiftRunBundle\CommandBus\Commands;

use RiftRunBundle\DTO\DTO;

class DTOAdapter implements Adapter
{
    /**
     * @var DTO
     */
    private $dto;

    public function __construct(DTO $dto)
    {
        $this->dto = $dto;
    }

    public function getDTO():DTO
    {
        return $this->dto;
    }
}