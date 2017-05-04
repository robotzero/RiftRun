<?php

namespace App\Domain\PlayerCharacter\Model;
use App\Domain\PlayerCharacter\ValueObject\PlayerCharacterId;
use App\Domain\SearchQuery\Model\SearchQuery;


/**
 * Class PlayerCharacter
 * @package App\Domain\PlayerCharacter\Model
 */
class PlayerCharacter
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var SearchQuery
     */
    private $searchQuery;

    /**
     * @var string
     */
    private $type;

    public function __construct(string $type, SearchQuery $searchQuery = null)
    {
        $this->id = new PlayerCharacterId();
        $this->searchQuery = $searchQuery;
        $this->type = $type;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id->__toString();
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
