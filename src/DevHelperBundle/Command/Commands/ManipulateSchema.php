<?php

namespace DevHelperBundle\Command\Commands;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

final class ManipulateSchema implements ManipulateSchemaInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getSchemaTool()
    {
        return new SchemaTool($this->entityManager);
    }

    public function getMetaData()
    {
        return $this->entityManager->getMetaDataFactory()->getAllMetadata();
    }

    public function getSchemaManager()
    {
        return $this->entityManager->getConnection()->getSchemaManager();
    }
}
