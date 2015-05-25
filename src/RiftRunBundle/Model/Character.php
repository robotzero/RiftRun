<?php

namespace RiftRunBundle\Model;

/**
 * Character
 */
class Character
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Character
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
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

    /**
     * Set paragonPoints
     *
     * @param integer $paragonPoints
     * @return Character
     */
    public function setParagonPoints($paragonPoints)
    {
        $this->paragonPoints = $paragonPoints;

        return $this;
    }

    /**
     * Get paragonPoints
     *
     * @return integer
     */
    public function getParagonPoints()
    {
        return $this->paragonPoints;
    }

    /**
     * Set battleTag
     *
     * @param string $battleTag
     * @return Character
     */
    public function setBattleTag($battleTag)
    {
        $this->battleTag = $battleTag;

        return $this;
    }

    /**
     * Get battleTag
     *
     * @return string
     */
    public function getBattleTag()
    {
        return $this->battleTag;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Character
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Character
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
