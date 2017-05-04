<?php

namespace App\Domain\GameMode\Model;

use App\Domain\GameMode\Exception\InvalidGameTypeException;
use App\Domain\GameMode\ValueObject\GameModeId;
use App\Domain\GameMode\ValueObject\GameType;
use Doctrine\Common\Util\Debug;

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
    protected $gameMode;

    /**
     * GameMode constructor.
     * @param GameModeId $id
     * @param string $gameMode
     */
    public function __construct(GameModeId $id, string $gameMode)
    {
        $this->id = $id;
        $this->gameMode = new GameType($gameMode);
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
    public function getGameMode(): GameType
    {
        return $this->gameMode;
    }

    public static function createGameMode(array $data): AbstractGameMode
    {
        if (array_key_exists('torment', $data)) {
            return new Rift($data['torment']->getData());
        }

        if (array_key_exists('level', $data)) {
            return new Grift($data['level']->getData());
        }

        throw new InvalidGameTypeException();
    }
}
