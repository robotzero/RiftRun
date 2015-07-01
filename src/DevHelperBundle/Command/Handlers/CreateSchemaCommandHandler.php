<?php

namespace DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\CreateSchemaInterface;

final class CreateSchemaCommandHandler
{
    public function handle(CreateSchemaInterface $createSchema)
    {
        if (empty($createSchema->getSchemaManager()->listTables()) === true) {
            $metadatas = $createSchema->getMetadata();
            $schemaTool = $createSchema->getSchemaTool();

            $schemaTool->createSchema($metadatas);
        }
    }
}
