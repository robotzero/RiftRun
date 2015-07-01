<?php

namespace spec\DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\CreateSchemaInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateSchemaCommandHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('DevHelperBundle\Command\Handlers\CreateSchemaCommandHandler');
    }

    function it_does_nothing_when_schema_manager_lists_tables(
        CreateSchemaInterface $createSchema,
        \Doctrine\DBAL\Schema\SqliteSchemaManager $schemaManager
    ) {
        $createSchema->getSchemaManager()->willReturn($schemaManager);
        $schemaManager->listTables()->willReturn(['something']);

        $createSchema->getMetadata()->shouldBeCalledTimes(0);
        $createSchema->getSchemaTool()->shouldBeCalledTimes(0);
        $this->handle($createSchema);
    }

    function it_delegates_to_schema_tool_to_create_schema(
        CreateSchemaInterface $createSchema,
        \Doctrine\DBAL\Schema\SqliteSchemaManager $schemaManager,
        \Doctrine\ORM\Tools\SchemaTool $schemaTool
    ) {
        $createSchema->getSchemaManager()->willReturn($schemaManager);
        $schemaManager->listTables()->willReturn([]);
        $createSchema->getMetadata()->willReturn([]);
        $createSchema->getSchemaTool()->willReturn($schemaTool);

        $this->handle($createSchema);
        $schemaTool->createSchema([])->shouldBeCalledTimes(1);
    }
}
