<?php

namespace DevHelperBundle\Command\Commands;

final class ClearDBQuery implements ClearDatabaseInterface
{
    /**
     * @var string
     */
    private $dql;

    public function __construct(string $dql = null)
    {
        $this->dql = $dql;
    }

    public function getDql():string
    {
        return $this->dql;
    }
}