<?php

namespace RiftRunBundle\Model;

class Wizard
{
    private $id;

    private $battleTag = 0;

    private $server = 'EU';

    private $paragonPoints = 0;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getBattleTag()
    {
        return $this->battleTag;
    }

    public function setBattleTag($battleTag)
    {
        $this->battleTag = $battleTag;

        return $this;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function setServer($server)
    {
        $this->server = $server;
    }

    public function getParagonPoints()
    {
        return $this->paragonPoints;
    }

    public function setParagonPoints($paragonPoints)
    {
        $this->paragonPoints = $paragonPoints;

        return $this;
    }
}
