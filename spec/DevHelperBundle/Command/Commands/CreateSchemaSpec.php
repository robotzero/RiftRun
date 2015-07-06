<?php

namespace spec\DevHelperBundle\Command\Commands;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\Mapping\ClassMetadataFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateSchemaSpec extends ObjectBehavior
{
    function let(EntityManagerInterface $entityManager)
    {
        $this->beConstructedWith($entityManager, true);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DevHelperBundle\Command\Commands\ManipulateSchema');
    }

    function it_should_implement_an_interface()
    {
        $this->shouldImplement('DevHelperBundle\Command\Commands\ManipulateSchemaInterface');
    }

    function it_delegates_to_metadatafactory_to_get_metadata(
        EntityManagerInterface $entityManager,
        ClassMetadataFactory $metadataFactory
    ) {
        $entityManager->getMetadataFactory()->willReturn($metadataFactory);

        $this->getMetadata();
        $metadataFactory->getAllMetadata()->shouldBeCalledTimes(1);
    }

    function it_returns_new_schema_tool(
        EntityManagerInterface $entityManager,
        \Doctrine\DBAL\Connection $connection,
        \Doctrine\ORM\Configuration $configuration
    ) {
        $entityManager->getConnection()->willReturn($connection);
        $entityManager->getConfiguration()->willReturn($configuration);

        $this->getSchemaTool()->shouldHaveType('Doctrine\ORM\Tools\SchemaTool');
    }

    function it_delegates_to_connection_to_get_schema_manager(
        EntityManagerInterface $entityManager,
        \Doctrine\DBAL\Connection $connection
    ) {
        $entityManager->getConnection()->willReturn($connection);
        $this->getSchemaManager();
        $connection->getSchemaManager()->shouldBeCalledTimes(1);
    }
}
