<?php

namespace DevHelperBundle\Command\Commands;

use RiftRunBundle\ORM\Specification\Specification;

interface ExecuteQueryInterface
{
    /**
     * @return Specification
     */
    public function getSpecification():Specification;
}