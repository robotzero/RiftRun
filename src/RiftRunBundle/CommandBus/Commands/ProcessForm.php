<?php

namespace RiftRunBundle\CommandBus\Commands;

interface ProcessForm
{
    public function getFormType():string;

    public function getRequestMethod():string;

    public function getRequestData():array;
}