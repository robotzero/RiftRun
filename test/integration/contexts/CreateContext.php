<?php

namespace Test\Integration\Context;

require_once __DIR__.'/../../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
require_once __DIR__.'/../../../src/AppKernel.php';

class CreateContext
{
    protected $container;

    protected $client;

    public function __construct($container)
    {
        $this->container = $container;
        $this->client = $this->container->get('test.client');
    }
}
