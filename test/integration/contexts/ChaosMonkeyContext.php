<?php

namespace Test\Integration\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Doctrine\Bundle\DoctrineBundle\Registry;
use RiftRunBundle\Model\Post;
use RiftRunBundle\Model\SearchQuery;

class ChaosMonkeyContext implements Context {

    private $doctrine;
    private $inMemoryFixtures = [];
    private $apiContext;

    /**
     * ChaosMonkeyContext constructor.
     * @param Registry $doctrine
     */
    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /** @BeforeScenario */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();
        $this->apiContext = $environment->getContext(ApiContext::class);
    }

    /**
     * @Given /^I have (\d+) posts missing (.*) object in table (.*)$/
     */
    public function iHavePostsMissingObject($broken, $obj, $name)
    {
        $this->inMemoryFixtures = $this->apiContext->getInMemoryFixtures();

        $postObjects = array_map(function ($item) use ($obj) {
            if ($item instanceof Post) {
                return $item;
            }
        }, $this->inMemoryFixtures);

        $ids = array_reduce($postObjects,  function ($carry, $item) use ($broken, $obj) {
            if ($item !== null && count(explode(',', $carry)) <= $broken) {
                $carry .= '"' . $item->$obj()->getId() . '",';
                return $carry;
            }
            return $carry;
        }, '');

        $connection = $this->doctrine->getManager()->getConnection();
        $ids = rtrim($ids, ',');
        $connection->executeQuery('DELETE FROM  ' . $name . ' where id in(' . $ids  . ')');
    }
}