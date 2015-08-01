<?php

namespace Test\Integration\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\AfterFeatureScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeFeatureScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Behat\WebApiExtension\Context\WebApiContext;
use DevHelperBundle\Command\Commands\ClearDatabase;
use DevHelperBundle\Command\Commands\CreateSchema;
use DevHelperBundle\Command\Commands\LoadFixtures;
use DevHelperBundle\Command\Commands\UpdateSchema;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Component\HttpKernel\KernelInterface;

require_once __DIR__.'/../../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
require_once __DIR__.'/../../../app/AppKernel.php';

/**
 * Defines application features from the specific context.
 */
class ApiContext extends MinkContext implements KernelAwareContext, Context, SnippetAcceptingContext
{
    protected $kernel;

    private $crawler = null;

    private $client = null;

    private $response = null;

    private $scope = null;

    private $doctrine = null;

    private static $entityManager = null;

    private static $mykernel = null;

    private static $commandBus = null;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(
        \Doctrine\Bundle\DoctrineBundle\Registry $doctrine
    ) {
        $this->doctrine   = $doctrine;
    }

    /** @BeforeScenario */
    public function before(BeforeScenarioScope $scope)
    {
        $this->client = $this->kernel->getContainer()->get('test.client');
        $this->client->setServerParameters([]);
        $this->resetScope();
    }

    public function setKernel(KernelInterface $kernelInterface)
    {
        $this->kernel = $kernelInterface;
    }

    /**
     * @Given /^I have at least (\d+) "([^"]*)" in the database$/
     */
    public function iHaveInTheDatabase($number, $record)
    {
        $connection = $this->doctrine->getManager()->getConnection();

        $record = (string) $record;
        $result = $connection->fetchAll('SELECT count() AS count FROM ' . $record);

        assertTrue($result[0]['count'] >= $number);
    }

    /**
     * @Given /^I have (\d+) posts missing "([^"]*)" object starting from (\d+)$/
     */
    public function iHavePostsMissingObject($broken, $obj, $id)
    {
        $connection = $this->doctrine->getManager()->getConnection();
        $ids = '';
        for($i = $id; $i < $id+10; $i++) {
            if ($i == ($id + 10) - 1) {
                $ids .= $i;
                break;
            }
            $ids .=$i . ', ';
        }

        $connection->executeQuery('DELETE FROM  ' . $obj . ' where id in(' . $ids  . ')');
    }

    /**
     * @Given /^I have at least (\d+) posts older than a month$/
     */
    public function iHaveAtLeastPostsOlderThanAMonth($oldPostsNumber)
    {
        $fileLocations = [
            'test/Fixtures/DatabaseSeeder/Post/posts_old_x10.yml'
        ];

        static::$commandBus->handle(new LoadFixtures($fileLocations));

        $connection = $this->doctrine->getManager()->getConnection();

        $result = $connection->fetchAll("SELECT count() AS count FROM posts WHERE createdAt < date('now', '-1 month')");

        assertTrue((int)$result[0]['count'] === 10);

    }

    /**
     * @When /^I request "(GET|PUT|POST|DELETE) ([^"]*)"$/
     */
    public function iRequest($httpMethod, $resource)
    {
        $this->crawler = $this->client->request($httpMethod, $resource);
        $this->response = $this->client->getResponse();
    }

    /**
     * @When /^I request "(GET|PUT|POST|DELETE) ([^"]*)" with parameters "([^"]*)"$/
     */
    public function iRequestsWithParameters($httpMethod, $resource, $params)
    {
        $this->crawler = $this->client->request($httpMethod, $resource . $params);
        $this->response = $this->client->getResponse();
    }

    /**
     * @When /^I request "(GET|PUT|POST|DELETE) ([^"]*)" with values:$/
     */
    public function IRequestsWithValues($httpMethod, $resource, TableNode $table)
    {
        $table = $table->getHash()[0];

        $payload = [
            "player" => ["type" => $table["type"], "paragonPoints" => $table["paragonPoints"], "battleTag" => $table["battleTag"], "region" => $table["region"], "seasonal" => $table["seasonal"], "gameType" => $table["gameType"]],
            "query"  => ["minParagon" => $table["minParagon"], "game" => ["type" => $table["game"], "level" => $table["level"]], "characterType" => [["type" => $table["char1"]], ["type" => $table["char2"]], ["type" => $table["char3"]], ["type" => $table["char4"]]]]
        ];

        $this->client->followRedirects(true);

        $this->crawler = $this->client->request(
            $httpMethod,
            $resource,
            [],
            [],
            [],
            $payload
        );

        $this->response = $this->client->getResponse();
    }

    /**
     * @Then /^I get a "([^"]*)" response$/
     */
    public function iGetAResponse($statusCode)
    {
        $contentType = $this->response->headers->get('content-type');
        assertTrue($this->response->isOk());
        assertEquals($contentType, 'application/json');
    }

    /**
     * @Given /^scope into the first "([^"]*)" property$/
     */
    public function scopeIntoTheFirstProperty($scope)
    {
        $this->scope = "{$scope}.0";
    }

    /**
     * @Given /^scope into the "([^"]*)" property$/
     */
    public function scopeIntoTheProperty($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @Given /^the properties exist:$/
     */
    public function thePropertiesExist(PyStringNode $propertiesString)
    {
        foreach (explode("\n", (string) $propertiesString) as $property) {
            $this->thePropertyExists($property);
        }
    }

    /**
     * @Given /^the "([^"]*)" property exists$/
     */
    public function thePropertyExists($property)
    {
        assertObjectHasAttribute($property, $this->getScopePayload(), 'Missing attribute');
    }

    /**
     * @Given /^the "([^"]*)" property contains (\d+) items$/
     */
    public function thePropertyContainsItems($property, $count)
    {
        $count = (int) $count;
        $payload = $this->getScopePayload();

        assertCount(
            $count,
            $this->arrayGet($payload, $property),
            "Asserting the [$property] property contains [$count] items: ".json_encode($payload)
        );
    }

    /**
     * @Given /^the "([^"]*)" property is an integer$/
     */
    public function thePropertyIsAnInteger($property)
    {
        assertInternalType('int', $this->arrayGet(
            $this->getScopePayload(),
            $property,
            "Asserting the [$property] property in current scope [{$this->scope}] is an integer: "
            )
        );
    }

    /**
     * @Given /^the "([^"]*)" property is a integer equalling "([^"]*)"$/
     */
    public function thePropertyIsAIntegerEqualling($property, $expectedValue)
    {
        $payload = $this->getScopePayload();
        $actualValue = $this->arrayGet($payload, $property);
        $this->thePropertyIsAnInteger($property);
        assertSame(
            $actualValue,
            (int) $expectedValue,
            "Asserting the [$property] property in current scope [{$this->scope}] is an integer equalling [$expectedValue]."
        );
    }

    /**
     * @Given /^the "([^"]*)" property is a string$/
     */
    public function thePropertyIsAString($property)
    {
        $payload = $this->getScopePayload();

        assertInternalType(
            'string',
            $this->arrayGet(
                $payload,
                $property,
                "Asserting the [$property] property in current scope [{$this->scope}] is a string: ".json_encode($payload)
            )
        );
    }

    /**
     * @Given /^the "([^"]*)" property is a string equalling "([^"]*)"$/
     */
    public function thePropertyIsAStringEqualling($property, $expectedValue)
    {
        $payload = $this->getScopePayload();
        $this->thePropertyIsAString($property);
        $actualValue = $this->arrayGet($payload, $property);

        assertSame(
            $actualValue,
            $expectedValue,
            "Asserting the [$property] property in current scope [{$this->scope}] is a string equalling [$expectedValue]."
        );
    }

    /**
     * @Given /^the "([^"]*)" property is an array$/
     */
    public function thePropertyIsAnArray($property)
    {
        $payload = $this->getScopePayload();
        $actualValue = $this->arrayGet($payload, $property);
        assertTrue(
            is_array($actualValue),
            "Asserting the [$property] property in current scope [{$this->scope}] is an array: ".json_encode($payload)
        );
    }

    /**
     * @Given /^the "([^"]*)" property is a boolean$/
     */
    public function thePropertyIsABoolean($property)
    {
        $payload = $this->getScopePayload();
        assertTrue(
            gettype($this->arrayGet($payload, $property)) == 'boolean',
            "Asserting the [$property] property in current scope [{$this->scope}] is a boolean."
        );
    }

    /**
     * @Given /^the "([^"]*)" property is a boolean equalling "([^"]*)"$/
     */
    public function thePropertyIsABooleanEqualling($property, $expectedValue)
    {
        $payload = $this->getScopePayload();
        $actualValue = $this->arrayGet($payload, $property);
        if (! in_array($expectedValue, ['true', 'false'])) {
            throw new \InvalidArgumentException("Testing for booleans must be represented by [true] or [false].");
        }
        $this->thePropertyIsABoolean($property);
        assertSame(
            $actualValue,
            $expectedValue == 'true',
            "Asserting the [$property] property in current scope [{$this->scope}] is a boolean equalling [$expectedValue]."
        );
    }

    /**
     * @Given /^the "([^"]*)" property is an object$/
     */
    public function thePropertyIsAnObject($property)
    {
        $payload = $this->getScopePayload();
        $actualValue = $this->arrayGet($payload, $property);
        assertTrue(
            is_object($actualValue),
            "Asserting the [$property] property in current scope [{$this->scope}] is an object: ".json_encode($payload)
        );
    }

    /**
     * @Then newest posts are displayed at the top
     */
    public function newestPostsAreDisplayedAtTheTop()
    {
        $createdAts = [];
        $scope = $this->getScopePayload();
        foreach ($scope->_embedded->items as $item) {
            $createdAts[] = $item->createdAt;
        }

        assertTrue($createdAts[0] > $createdAts[9]);
    }

    /**
     * @Given I have :arg1 posts in the database with created date :arg2 days old
     */
    public function iHavePostsInTheDatabaseWithCreatedDateDaysOld($arg1, $arg2)
    {
        $fileLocations = [
            'test/Fixtures/DatabaseSeeder/Post/posts_29_old_x10.yml'
        ];

        static::$commandBus->handle(new LoadFixtures($fileLocations));

        $connection = $this->doctrine->getManager()->getConnection();

        $result = $connection->fetchAll("SELECT count() AS count FROM posts WHERE createdAt <= date('now', '-27 days') AND createdAt >= date('now', '-29 days')");

        assertTrue((int)$result[0]['count'] >= 5);
    }

    /**
     * @When :arg1 old posts are displayed at the last page
     */
    public function oldPostsAreDisplayedAtTheLastPage($arg1)
    {
        $scope = $this->getScopePayload();

        $oldCreatedAt = $scope->_embedded->items[0]->createdAt;

        $this->crawler = $this->client->request("GET", "/v1/posts");
        $this->response = $this->client->getResponse();

        $scope = $this->getScopePayload();
        $createdAt = $scope->_embedded->items[0]->createdAt;
        $this->resetScope();
        assertTrue($oldCreatedAt < $createdAt);
    }

    public function resetScope()
    {
        $this->scope = null;
    }

    private function getBody()
    {
        return json_decode($this->response->getContent());
    }

    private function getScopePayload()
    {
        $payload = $this->getBody();

        if (null === $this->scope) {
            return $payload;
        }

        return $this->arrayGet($payload, $this->scope);
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @copyright   Taylor Otwell
     * @link        http://laravel.com/docs/helpers
     * @param       array   $array
     * @param       string  $key
     * @param       mixed   $default
     * @return      mixed
     */
    protected function arrayGet($array, $key)
    {
        if (is_null($key)) {
            return $array;
        }

        foreach (explode('.', $key) as $segment) {
            if (is_object($array)) {
                if (! isset($array->{$segment})) {
                    return;
                }
                $array = $array->{$segment};
            } elseif (is_array($array)) {
                if (! array_key_exists($segment, $array)) {
                    return;
                }
                $array = $array[$segment];
            }
        }
        return $array;
    }

    /** @BeforeFeature */
    public static function loadTheFixtures(BeforeFeatureScope $scope)
    {
        self::$mykernel = new \AppKernel('test', false);
        self::$mykernel->boot();

        self::$entityManager = self::$mykernel->getContainer()->get('doctrine')->getManager();
        self::$commandBus = self::$mykernel->getContainer()->get('tactician.commandbus.default');
        self::$commandBus->handle(new CreateSchema(self::$entityManager));
        self::$commandBus->handle(new UpdateSchema(self::$entityManager));

        if ($scope->getFeature()->hasBackground() === false) {
            return;
            //throw new \Exception('Do not know how to load fixtures.');
        }

        $background = $scope->getFeature()->getBackground();
        $title = $background->getTitle();

        $record = explode(' ', $title)[1];
        $number = explode(' ', $title)[0];

        $fileLocations = [
            'test/Fixtures/DatabaseSeeder/' .
            ucfirst($record) . '/' . $record .
            '_x' . $number . '.yml'
        ];

        self::$commandBus->handle(new LoadFixtures($fileLocations));
    }

    /** @AfterFeature */
    public static function cleanTheFixtures(AfterFeatureScope $scope)
    {
        self::$commandBus->handle(new ClearDatabase());
    }
}
