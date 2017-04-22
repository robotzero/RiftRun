<?php

namespace App\Domain\Player\Model;

/**
 * Class Player
 * @package App\Domain\Player\Model
 */
class Player
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
        $id,
        string $type,
        int $paragonPoints,
        string $battleTag,
        string $region,
        string $seasonal,
        string $gameType,
        \DateTime $createdAt
    ) {
        $this->id = $id;
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

    /**
     * Get paragonPoints
     *
     * @return integer
     */
    public function getParagonPoints(): int
    {
        return $this->paragonPoints;
    }

    /**
     * Get battleTag
     *
     * @return string
     */
    public function getBattleTag(): string
    {
        return $this->battleTag;
    }

    /**
     * Get region
     *
     * @return string //TODO VALUE OBJECT OR EMBEDDED
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * Get seasonal
     *
     * @return boolean
     */
    public function getSeasonal(): bool
    {
        return $this->seasonal;
    }

    /**
     * Get gameType
     *
     * @return string
     */
    public function getGameType(): string
    {
        return $this->gameType;
    }
}
