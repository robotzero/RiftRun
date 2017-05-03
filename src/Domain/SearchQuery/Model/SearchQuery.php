<?php

namespace App\Domain\SearchQuery\Model;

use App\Domain\GameMode\Model\AbstractGameMode;
use App\Domain\SearchQuery\ValueObject\SearchQueryId;
use Doctrine\Common\Collections\Collection;

/**
 * Class SearchQuery
 * @package App\Domain\SearchQuery\Model
 */
class SearchQuery
{
    /**
     * @var SearchQueryId
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

    private $game;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $characterType;

    /**
     * Constructor
     * @param SearchQueryId $id
     * @param int $minParagon
     * @internal param GameType $game
     * @internal param \DateTime $createdAt
     */
//    public function __construct(int $minParagon, GameType $game, \DateTime $createdAt)
//    {
//        $this->characterType = new ArrayCollection();
//        $this->game = $game;
//        $this->minParagon = $minParagon;
//        $this->createdAt = $createdAt;
//    }
    public function __construct(SearchQueryId $id, $game, int $minParagon)
    {
        $this->id = $id;
        $this->minParagon = $minParagon;
        $this->createdAt = new \DateTime('now');
        $this->game = $game;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id->__toString();
    }

    /**
     * Get minParagon
     *
     * @return integer
     */
    public function getMinParagon(): int
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
     */
    public function getGame():AbstractGameMode
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
//    public function addCharacterType(CharacterType $characterType)
//    {
//        $this->characterType->add($characterType);
//
//        return $this;
//    }

    /**
     * Remove characterType
     *
     * @param CharacterType $characterType
     */
//    public function removeCharacterType(CharacterType $characterType)
//    {
//        $this->characterType->removeElement($characterType);
//    }

    /**
     * Get characterType
     *
     * @return \Doctrine\Common\Collections\Collection
     */
//    public function getCharacterType():Collection
//    {
//        return $this->characterType;
//    }
}
