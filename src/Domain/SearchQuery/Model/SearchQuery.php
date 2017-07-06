<?php

namespace App\Domain\SearchQuery\Model;

use App\Domain\GameMode\Model\GameMode;
use App\Domain\PlayerCharacter\Model\PlayerCharacter;
use App\Domain\SearchQuery\ValueObject\SearchQueryId;
use Doctrine\Common\Collections\ArrayCollection;
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

    private $gameMode;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $playerCharacters;

    /**
     * SearchQuery constructor.
     * @param SearchQueryId $id
     * @param GameMode $gameMode
     * @param int $minParagon
     */
    public function __construct(SearchQueryId $id, GameMode $gameMode = null, int $minParagon = null)
    {
        $this->id = $id;
        $this->minParagon = $minParagon;
        $this->createdAt = new \DateTime('now');
        $this->gameMode = $gameMode;
        $this->playerCharacters = new ArrayCollection();
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
     * Get gameMode
     *
     */
    public function getGameMode():GameMode
    {
        return $this->gameMode;
    }

    /**
     * Add playerCharacter
     *
     * @param PlayerCharacter $playerCharacter
     *
     * @return SearchQuery
     */
    public function addPlayerCharacter(PlayerCharacter $playerCharacter)
    {
        $this->playerCharacters->add($playerCharacter);
        return $this;
    }

    /**
     * Remove playerCharacter
     *
     * @param PlayerCharacter $playerCharacter
     */
    public function removeCharacterType(PlayerCharacter $playerCharacter)
    {
        $this->playerCharacters->removeElement($playerCharacter);
    }

    /**
     * Get playerCharacters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayerCharacters():Collection
    {
        return $this->playerCharacters;
    }

    /**
     * Remove gameMode
     */
    public function removeGameMode(): void
    {
        $this->gameMode = null;
    }

    public function removePlayerCharacters(): void
    {
        $this->playerCharacters = new ArrayCollection();
    }
}
