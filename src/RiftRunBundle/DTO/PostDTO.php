<?php

namespace RiftRunBundle\DTO;

class PostDTO implements DTO
{
    /**
     * @var string
     */
    public $id;

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

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}