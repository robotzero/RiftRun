<?php

namespace RiftRunBundle\Model;

/**
 * CharacterType
 */
class CharacterType
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
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
}
