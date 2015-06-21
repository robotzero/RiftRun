<?php

namespace RiftRunBundle\Model;

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
     * @var \RiftRunBundle\Model\Character
     */
    private $player;

    /**
     * @var \RiftRunBundle\Model\SearchQuery
     */
    private $query;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Post
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
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
     * Set player
     *
     * @param \RiftRunBundle\Model\Character $player
     *
     * @return Post
     */
    public function setPlayer(\RiftRunBundle\Model\Character $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \RiftRunBundle\Model\Character
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set query
     *
     * @param \RiftRunBundle\Model\SearchQuery $query
     *
     * @return Post
     */
    public function setQuery(\RiftRunBundle\Model\SearchQuery $query = null)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get query
     *
     * @return \RiftRunBundle\Model\SearchQuery
     */
    public function getQuery()
    {
        return $this->query;
    }
}
