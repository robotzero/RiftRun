<?php

namespace RiftRunBundle\Model;

/**
 * CharacterType
 */
class CharacterType
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \RiftRunBundle\Model\SearchQuery
     */
    private $searchQuery;

    public function __construct(string $type)
    {
        $this->type = $type;
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
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set searchQuery
     *
     * @param \RiftRunBundle\Model\SearchQuery $searchQuery
     *
     * @return CharacterType
     */
//    public function setSearchQuery(\RiftRunBundle\Model\SearchQuery $searchQuery = null)
//    {
//        $this->searchQuery = $searchQuery;
//
//        return $this;
//    }

    /**
     * Get searchQuery
     *
     * @return \RiftRunBundle\Model\SearchQuery
     */
//    public function getSearchQuery()
//    {
//        return $this->searchQuery;
//    }
}
