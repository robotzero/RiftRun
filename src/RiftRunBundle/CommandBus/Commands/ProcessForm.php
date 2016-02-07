<?php

namespace RiftRunBundle\CommandBus\Commands;

use Symfony\Component\HttpFoundation\Request;

interface ProcessForm
{
    public function getFormType():string;

    public function getRequestMethod():string;

    public function getRequestData():array;

    public function getRequest():Request;
}