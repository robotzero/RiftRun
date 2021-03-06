<?php

namespace App\DTO;

class CharacterDTO implements DTO
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $type;

    /**
     * @var integer
     */
    public $paragonPoints;

    /**
     * @var string
     */
    public $battleTag;

    /**
     * @var string
     */
    public $region;

    /**
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @var boolean
     */
    public $seasonal;

    /**
     * @var string
     */
    public $gameType;
}