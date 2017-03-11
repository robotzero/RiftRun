<?php

namespace Test\Integration\Context;

use Behat\Behat\Context\Context;
use Doctrine\Bundle\DoctrineBundle\Registry;

class ChaosMonkeyContext implements Context {

    private $doctrine;
    private $repositoryAlias = 'RiftRunners:';

    /**
     * ChaosMonkeyContext constructor.
     * @param Registry $doctrine
     */
    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Given /^I have (\d+) posts missing (.*)$/
     * @param int $numberMissing
     * @param string $object
     */
    public function iHavePostsMissingObject(int $numberMissing , string $object)
    {
        $enityManager = $this->doctrine->getManager();
        $allEntities = $enityManager->getRepository($this->repositoryAlias . $object)->findAll();
        $slicedEntities = array_slice($allEntities, count($allEntities) - $numberMissing);
        foreach ($slicedEntities as $eachEntity) {
            $enityManager->remove($eachEntity);
        }
        $enityManager->flush();
    }
}