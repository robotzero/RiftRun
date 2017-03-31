<?php

namespace App\Model;
use App\Model\CharacterType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;

/**
 * SearchQuery
 */
class SearchQuery
{
    /**
     * @var Uuid
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
     * @var \App\Model\GameType
     */
    private $game;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $characterType;

    /**
     * Constructor
     * @param int $minParagon
     * @param GameType $game
     * @param \DateTime $createdAt
     */
    public function __construct(int $minParagon, GameType $game, \DateTime $createdAt)
    {
        $this->characterType = new ArrayCollection();
        $this->game = $game;
        $this->minParagon = $minParagon;
        $this->createdAt = $createdAt;
    }

    /**
     * Get id
     *
     * @return Uuid
     */
    public function getId():Uuid
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
     * @return \App\Model\GameType
     */
    public function getGame():GameType
    {
        return $this->game;
    }

    /**
     * Add characterType
     *
     * @param CharacterType $characterType
     *
     * @return SearchQuery
     */
    public function addCharacterType(CharacterType $characterType)
    {
        $this->characterType->add($characterType);

        return $this;
    }

    /**
     * Remove characterType
     *
     * @param CharacterType $characterType
     */
    public function removeCharacterType(CharacterType $characterType)
    {
        $this->characterType->removeElement($characterType);
    }

    /**
     * Get characterType
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCharacterType():Collection
    {
        return $this->characterType;
    }
}
