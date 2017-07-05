<?php

namespace App\Domain\Post\Model;

use App\Domain\Player\Model\Player;
use App\Domain\Post\ValueObject\PostId;
use App\Domain\SearchQuery\Model\SearchQuery;

/**
 * Class Post
 * @package App\Domain\Post\Model
 */
class Post
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var Player
     */
    private $player;

    /**
     * @var \App\Domain\SearchQuery\Model\SearchQuery
     */
    private $query;

    public function __construct(PostId $id, Player $player, SearchQuery $searchQuery)
    {
        $this->id = $id;
        $this->player = $player;
        $this->query = $searchQuery;
        $this->createdAt = new \DateTime('now');
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
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get player
     *
     * @return \App\Domain\Player\Model\Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * Get query
     *
     * @return \App\Domain\SearchQuery\Model\SearchQuery
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Remove query
     */
    public function removeQuery(): void
    {
        $this->query = null;
    }
}
