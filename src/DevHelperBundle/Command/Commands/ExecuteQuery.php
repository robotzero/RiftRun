<?php

namespace DevHelperBundle\Command\Commands;

use RiftRunBundle\ORM\Specification\Specification;

final class ExecuteQuery implements ExecuteQueryInterface
{
    /** @var  Specification */
    private $querySpecification;

    public function __construct(Specification $querySpecification)
    {
        $this->querySpecification = $querySpecification;
    }

    /**
     * @return Specification
     */
    public function getSpecification():Specification
    {
        return $this->querySpecification;
    }
}