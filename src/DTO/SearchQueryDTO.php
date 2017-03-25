<?php

namespace App\DTO;

class SearchQueryDTO implements DTO
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var integer
     */
    public $minParagon;

    /**
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @var \App\Model\GameType
     */
    public $game;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    public $characterType;
}