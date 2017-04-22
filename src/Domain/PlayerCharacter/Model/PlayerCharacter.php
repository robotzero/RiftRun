<?php

namespace App\Domain\PlayerCharacter\Model;


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

//    public function __construct(SearchQuery $searchQuery, string $type)
//    {
//        $this->searchQuery = $searchQuery;
//        $this->type = $type;
//    }

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
    public function getType(): string
    {
        return $this->type;
    }
}
