<?php

namespace DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\ManipulateSchemaInterface;

final class UpdateSchemaCommandHandler
{
    public function handle(ManipulateSchemaInterface $updateSchema)
    {
        $metadatas = $updateSchema->getMetadata();
        $schemaTool = $updateSchema->getSchemaTool();

        $schemaTool->updateSchema($metadatas);
    }
}
