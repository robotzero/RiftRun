<?php

namespace App\Model;

/**
 * Character
 */
class Character
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */
    private $paragonPoints;

    /**
     * @var string
     */
    private $battleTag;

    /**
     * @var string
     */
    private $region;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var boolean
     */
    private $seasonal;

    /**
     * @var string
     */
    private $gameType;

    public function __construct(
        string $type,
        int $paragonPoints,
        string $battleTag,
        string $region,
        string $seasonal,
        string $gameType,
        \DateTime $createdAt
    ) {
        $this->type = $type;
        $this->paragonPoints = $paragonPoints;
        $this->battleTag = $battleTag;
        $this->region = $region;
        $this->seasonal = $seasonal;
        $this->gameType = $gameType;
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
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get paragonPoints
     *
     * @return integer
     */
    public function getParagonPoints()
    {
        return $this->paragonPoints;
    }

    /**
     * Get battleTag
     *
     * @return string
     */
    public function getBattleTag()
    {
        return $this->battleTag;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
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
     * Get seasonal
     *
     * @return boolean
     */
    public function getSeasonal()
    {
        return $this->seasonal;
    }

    /**
     * Get gameType
     *
     * @return string
     */
    public function getGameType()
    {
        return $this->gameType;
    }
}
