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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
