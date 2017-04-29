<?php

namespace App\Domain\GameMode\Model;

use App\Domain\GameMode\ValueObject\GameModeId;
use App\Domain\GameMode\ValueObject\GameType;

/**
 * Class GameMode
 * @package App\Domain\GameMode\Model
 */
abstract class AbstractGameMode
{
    /**
     * @var GameModeId
     */
    protected $id;

    /**
     * @var GameType
     */
    protected $type;

    /**
     * GameMode constructor.
     * @param GameModeId $id
     * @param string $type
     */
    public function __construct(GameModeId $id, string $type)
    {
        $this->id = $id;
        $this->type = new GameType($type);
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
     * @return GameType
     */
    public function getType(): GameType
    {
        return $this->type;
    }
}
