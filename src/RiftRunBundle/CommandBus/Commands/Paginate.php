<?php

namespace RiftRunBundle\CommandBus\Commands;

use RiftRunBundle\ORM\Specification\Specification;

interface Paginate
{
    public function getLimit():int;

    public function getPageNumber():int;

    public function getRepository(string $repositoryName);

    public function getDefaultSpecification():Specification;
}