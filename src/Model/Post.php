<?php

namespace App\Model;

/**
 * Post
 */
class Post
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \App\Model\Character
     */
    private $player;

    /**
     * @var \App\Model\SearchQuery
     */
    private $query;

    public function __construct(Character $player, SearchQuery $query, \DateTime $createdAt)
    {
        $this->player = $player;
        $this->query = $query;
        $this->createdAt = $createdAt;
    }

    /**
     * Get id
     *
     * @return integer
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

    /**
     * Get player
     *
     * @return \App\Model\Character
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Get query
     *
     * @return \App\Model\SearchQuery
     */
    public function getQuery()
    {
        return $this->query;
    }
}
