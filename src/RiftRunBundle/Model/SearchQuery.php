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
    private $gameType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $lookingFor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lookingFor = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set gameType
     *
     * @param \RiftRunBundle\Model\GameType $gameType
     *
     * @return SearchQuery
     */
    public function setGameType(\RiftRunBundle\Model\GameType $gameType = null)
    {
        $this->gameType = $gameType;

        return $this;
    }

    /**
     * Get gameType
     *
     * @return \RiftRunBundle\Model\GameType
     */
    public function getGameType()
    {
        return $this->gameType;
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
}
