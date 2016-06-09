<?php

namespace DevHelperBundle\Command\Handlers;

use DevHelperBundle\Command\Commands\ExecuteQueryInterface;

final class ExecuteQueryCommandHandler
{
    /**
     * @param ExecuteQueryInterface $clearDatabaseQuery
     */
    public function handle(ExecuteQueryInterface $clearDatabaseQuery)
    {
        echo "BLAH";
    }
}