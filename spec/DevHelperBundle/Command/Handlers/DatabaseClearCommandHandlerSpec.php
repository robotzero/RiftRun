<?php

namespace spec\DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\ClearDatabaseInterface;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DatabaseClearCommandHandlerSpec extends ObjectBehavior
{
    function let(EntityManagerInterface $entityManager)
    {
        $this->beConstructedWith($entityManager, true);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DevHelperBundle\Command\Handlers\DatabaseClearCommandHandler');
    }

    function it_delegates_to_connection_to_exec_delete_query(ClearDatabaseInterface $clearDatabase, EntityManagerInterface $entityManager, Connection $connection)
    {
        $entityManager->getConnection()->willReturn($connection);
        $this->handle($clearDatabase);
        $connection->exec("DELETE FROM characters")->shouldHaveBeenCalledTimes(1);
    }
}
