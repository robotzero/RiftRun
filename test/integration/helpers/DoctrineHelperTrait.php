<?php

namespace Test\Integration\Helpers;

use AppKernel;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use RiftRunBundle\Services\PostQueryService;
use Symfony\Component\DependencyInjection\ContainerInterface;

trait DoctrineHelperTrait {

    protected static $schemaIsReady = false;

    protected static $truncateTablesSQL = [];

    protected static $needToReload = false;

    /**
     * @return ContainerInterface
     */
    abstract public function getContainer();

    protected function rememberToReloadEntities()
    {
        self::$needToReload = true;
    }

    protected function reloadChanges()
    {
        if (!self::$needToReload) {
            return;
        }

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $im = $em->getUnitOfWork()->getIdentityMap();
        foreach ($im as $entities) {
            foreach ($entities as $entity) {
                $em->refresh($entity);
            }
        }
    }

    public function flushChanges()
    {
        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();
    }

    public function createSchema() : void{
        if (self::$schemaIsReady) {
            return;
        }
        $this->createSchemaFromScratch();
    }

    public function cleanupDatabase()
    {
        if (self::$schemaIsReady) {
            $this->truncateTables();
        } else{
            $this->createSchemaFromScratch();
        }
    }

    public function getCurrentEntitiesCount(string $entityName):int
    {
        $enityManager = $this->doctrine->getManager();
        $allEntities = $enityManager->getRepository('RiftRunners:' . $entityName)->findAll();
        return count($allEntities);
    }

    private function truncateTables()
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $connection = $em->getConnection();
        foreach (self::$truncateTablesSQL as $sql) {
            $connection->exec($sql);
        }
        self::$truncateTablesSQL = null;
    }

    private function createSchemaFromScratch()
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $metadata = $em->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $tool = new SchemaTool($em);
            $tool->dropSchema($metadata);
            $tool->createSchema($metadata);
        }

        $connection = $em->getConnection();

        // truncate all tables
        foreach ($connection->getSchemaManager()->listTableNames() as $tableName) {
            self::$truncateTablesSQL[] = sprintf(
                'delete from %s;',
                $tableName
            );
        }
        self::$schemaIsReady = true;
    }

    public function cleanAfterScenario()
    {
        self::$needToReload = true;
        $this->reloadChanges();
    }

    /**
     * @AfterScenario
     */
    public function deleteAll()
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        foreach ($em->getConnection()->getSchemaManager()->listTableNames() as $tableName) {
            self::$truncateTablesSQL[] = sprintf(
                'delete from %s;',
                $tableName
            );
        }
        $this->truncateTables();
    }

    protected function dbGet($id, $repositoryName)
    {
        /** @var  $postQueryService */
        $postQueryService = new PostQueryService($this->doctrine);
        return $postQueryService->query($repositoryName, $id);
    }

    /**
     * @AfterScenario @cleanFixtures
     * @param AfterScenarioScope $scope
     */
    public function deleteFixtures(AfterScenarioScope $scope)
    {
        $this->cleanupDatabase();
    }

    /**
     * @AfterSuite
     */
    public static function cleanDatabase()
    {
        $kernel = new AppKernel('test', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        /** @var EntityManager $em */
        $em = $container->get('doctrine.orm.entity_manager');
        $connection = $em->getConnection();
        foreach ($connection->getSchemaManager()->listTableNames() as $tableName) {
            self::$truncateTablesSQL[] = sprintf(
                'delete from %s;',
                $tableName
            );
        }
        foreach (self::$truncateTablesSQL as $sql) {
            $connection->exec($sql);
        }
    }
}
