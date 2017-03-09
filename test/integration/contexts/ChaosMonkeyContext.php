<?php

namespace Test\Integration\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
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
     * @Given /^I have (\d+) posts missing (.*) in table (.*) accessible via (.*)$/
     */
    public function iHavePostsMissingObject($broken, $obj, $name, $method)
    {
        $this->inMemoryFixtures = $this->apiContext->getInMemoryFixtures();

        $inst = sprintf('RiftRunBundle\\Model\\%s', $obj );

        $postObjects = array_map(function ($item) use ($inst) {
            if ($item instanceof $inst) {
                return $item;
            }
        }, $this->inMemoryFixtures);

        $ids = array_reduce($postObjects,  function ($carry, $item) use ($broken, $obj, $method) {
            if ($item !== null && count(explode(',', $carry)) <= $broken) {
                if ($item->$method() instanceof PersistentCollection) {
                    /** @var array $arr */
                    $arr = $item->$method()->toArray();
                    foreach($arr as $key => $value) {
                        $carry .= '"' . $value->getId() . '",';
                        return $carry;
                    }
                } else {
                    $carry .= '"' . $item->$method()->getId() . '",';
                }
                return $carry;
            }
            return $carry;
        }, '');

        $connection = $this->doctrine->getManager()->getConnection();
        $ids = rtrim($ids, ',');
        $connection->executeQuery('DELETE FROM  ' . $name . ' where id in(' . $ids  . ')');
    }
}