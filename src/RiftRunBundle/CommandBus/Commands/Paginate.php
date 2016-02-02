<?php

namespace RiftRunBundle\CommandBus\Commands;

use Hateoas\Configuration\Route;
use RiftRunBundle\ORM\Specification\Specification;

interface Paginate
{
    /**
     * @return int
     */
    public function getLimit():int;

    /**
     * @return int
     */
    public function getPageNumber():int;

    /**
     * @return Route
     */
    public function getRoute():Route;

    /**
     * @return Specification
     */
    public function getDefaultSpecification():Specification;
}