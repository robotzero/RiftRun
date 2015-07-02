<?php

namespace DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\CreateSchemaInterface;

final class UpdateSchemaCommandHandler
{
    public function handle(CreateSchemaInterface $createSchema)
    {
        $metadatas = $createSchema->getMetadata();
        $schemaTool = $createSchema->getSchemaTool();

        $schemaTool->updateSchema($metadatas);
    }
}
