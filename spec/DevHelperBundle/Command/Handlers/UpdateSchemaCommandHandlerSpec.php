<?php

namespace spec\DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\ManipulateSchemaInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateSchemaCommandHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('DevHelperBundle\Command\Handlers\UpdateSchemaCommandHandler');
    }

    function it_delegates_to_schema_tool_to_update_schema(
        ManipulateSchemaInterface $updateSchema,
        \Doctrine\ORM\Tools\SchemaTool $schemaTool
    ) {
        $updateSchema->getMetadata()->willReturn([]);
        $updateSchema->getSchemaTool()->willReturn($schemaTool);

        $this->handle($updateSchema);

        $schemaTool->updateSchema([])->shouldBeCalledTimes(1);
    }
}
