<?php

namespace RiftRunBundle\Model;

/**
 * SearchQuery
 */
class SearchQuery
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $minParagon;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \RiftRunBundle\Model\GameType
     */
    private $game;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $characterType;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->characterType = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set minParagon
     *
     * @param integer $minParagon
     *
     * @return SearchQuery
     */
    public function setMinParagon($minParagon)
    {
        $this->minParagon = $minParagon;

        return $this;
    }

    /**
     * Get minParagon
     *
     * @return integer
     */
    public function getMinParagon()
    {
        return $this->minParagon;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return SearchQuery
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
     * Set game
     *
     * @param \RiftRunBundle\Model\GameType $game
     *
     * @return SearchQuery
     */
    public function setGame(\RiftRunBundle\Model\GameType $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \RiftRunBundle\Model\GameType
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Add characterType
     *
     * @param \RiftRunBundle\Model\CharacterType $characterType
     *
     * @return SearchQuery
     */
    public function addCharacterType(\RiftRunBundle\Model\CharacterType $characterType)
    {
        //$this->characterType[] = $characterType;
        $characterType->setSearchQuery($this);

        //$this->tags->add($tag);
        $this->characterType->add($characterType);

        return $this;
    }

    /**
     * Remove characterType
     *
     * @param \RiftRunBundle\Model\CharacterType $characterType
     */
    public function removeCharacterType(\RiftRunBundle\Model\CharacterType $characterType)
    {
        $this->characterType->removeElement($characterType);
    }

    /**
     * Get characterType
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCharacterType()
    {
        return $this->characterType;
    }
}
