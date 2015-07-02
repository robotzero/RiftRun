<?php

namespace DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\ManipulateSchemaInterface;

final class CreateSchemaCommandHandler
{
    public function handle(ManipulateSchemaInterface $createSchema)
    {
        if (empty($createSchema->getSchemaManager()->listTables()) === true) {
            $metadatas = $createSchema->getMetadata();
            $schemaTool = $createSchema->getSchemaTool();

            $schemaTool->createSchema($metadatas);
        }
    }
}
