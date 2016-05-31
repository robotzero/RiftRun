<?php

namespace RiftRunBundle\Model;

/**
 * Rift
 */
class Rift extends GameType
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var int
     */
    private $torment;

    public function __construct(int $torment)
    {
        $this->torment = $torment;
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
     * Get torment
     *
     * @return int
     */
    public function getTorment()
    {
        return $this->torment;
    }
}

