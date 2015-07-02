<?php

namespace DevHelperBundle\Command\Commands;

interface ManipulateSchemaInterface
{
    public function getSchemaTool();

    public function getMetadata();

    public function getSchemaManager();
}
