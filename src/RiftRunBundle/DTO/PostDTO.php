<?php

namespace RiftRunBundle\DTO;

class PostDTO implements DTO
{
    /**
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @var \RiftRunBundle\Model\Character
     */
    public $player;

    /**
     * @var \RiftRunBundle\Model\SearchQuery
     */
    public $query;
}