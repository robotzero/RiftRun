<?php

namespace RiftRunBundle\Model;

/**
 * Grift
 */
class Grift extends GameType
{
    /**
     * @var integer
     */
    private $id;


    /**
     * @var string
     */
    private $level;

    public function __construct(string $level)
    {
        $this->level = $level;
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
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }
}
