<?php

namespace DevHelperBundle\Command\Commands;

interface CreateSchemaInterface
{
    public function getSchemaTool();

    public function getMetadata();

    public function getSchemaManager();
}
