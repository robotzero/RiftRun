<?php

namespace App\DTO;

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
     * @var \App\Model\Character
     */
    public $player;

    /**
     * @var \App\Model\SearchQuery
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