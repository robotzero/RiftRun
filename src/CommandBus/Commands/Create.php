<?php

namespace App\CommandBus\Commands;

interface Create
{
    public function getFormType():string;

    public function getRequestMethod():string;

    public function getRequestData():array;
}