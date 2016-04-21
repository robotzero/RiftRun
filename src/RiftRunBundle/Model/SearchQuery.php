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
    public function __construct(int $minParagon, GameType $game, \DateTime $createdAt)
    {
        $this->characterType = new \Doctrine\Common\Collections\ArrayCollection();
        $this->game = $game;
        $this->minParagon = $minParagon;
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
     * Get minParagon
     *
     * @return integer
     */
    public function getMinParagon()
    {
        return $this->minParagon;
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
