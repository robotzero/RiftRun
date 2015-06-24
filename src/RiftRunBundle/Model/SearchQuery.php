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
    private $characterClass;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->characterClass = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add lookingFor
     *
     * @param \RiftRunBundle\Model\CharacterClass $lookingFor
     *
     * @return SearchQuery
     */
    public function addLookingFor(\RiftRunBundle\Model\CharacterClass $lookingFor)
    {
        $this->lookingFor[] = $lookingFor;

        return $this;
    }

    /**
     * Remove lookingFor
     *
     * @param \RiftRunBundle\Model\CharacterClass $lookingFor
     */
    public function removeLookingFor(\RiftRunBundle\Model\CharacterClass $lookingFor)
    {
        $this->lookingFor->removeElement($lookingFor);
    }

    /**
     * Get lookingFor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLookingFor()
    {
        return $this->lookingFor;
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
     * Add characterClass
     *
     * @param \RiftRunBundle\Model\CharacterClass $characterClass
     *
     * @return SearchQuery
     */
    public function addCharacterClass(\RiftRunBundle\Model\CharacterClass $characterClass)
    {
        $this->characterClass[] = $characterClass;

        return $this;
    }

    /**
     * Remove characterClass
     *
     * @param \RiftRunBundle\Model\CharacterClass $characterClass
     */
    public function removeCharacterClass(\RiftRunBundle\Model\CharacterClass $characterClass)
    {
        $this->characterClass->removeElement($characterClass);
    }

    /**
     * Get characterClass
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCharacterClass()
    {
        return $this->characterClass;
    }
}
