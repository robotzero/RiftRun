<?php

namespace spec\DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\ClearDatabaseInterface;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\PurgerInterface;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DatabaseClearCommandHandlerSpec extends ObjectBehavior
{
    function let(
        EntityManagerInterface $entityManager,
        PurgerInterface $purger
    ) {
        $this->beConstructedWith($entityManager, $purger);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DevHelperBundle\Command\Handlers\DatabaseClearCommandHandler');
    }

    function it_delegates_to_connection_to_exec_delete_query(
        ClearDatabaseInterface $clearDatabase,
        EntityManagerInterface $entityManager,
        PurgerInterface $purger,
        ORMExecutor $executor
    ) {
        $clearDatabase->getORMExecutor($entityManager, $purger)->willReturn($executor);
        $this->handle($clearDatabase);

        $executor->purge()->shouldHaveBeenCalledTimes(1);
        $entityManager->clear()->shouldHaveBeenCalledTimes(1);
    }
}
