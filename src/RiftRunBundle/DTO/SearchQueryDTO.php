<?php

namespace RiftRunBundle\DTO;

class SearchQueryDTO implements DTO
{
    /**
     * @var integer
     */
    public $minParagon;

    /**
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @var \RiftRunBundle\Model\GameType
     */
    public $game;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    public $characterType;
}