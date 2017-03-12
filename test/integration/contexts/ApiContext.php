<?php

namespace Test\Integration\Context;

use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\ScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use League\Tactician\CommandBus;
use Psr\Container\ContainerInterface;
use RiftRunBundle\Model\Post;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\DomCrawler\Crawler;
use Test\Integration\Helpers\DoctrineHelperTrait;
use DevHelperBundle\Command\Commands\LoadFixtures;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;

require_once __DIR__.'/../../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
require_once __DIR__.'/../../../app/AppKernel.php';

/**
 * Defines application features from the specific context.
 */
class ApiContext extends MinkContext implements KernelAwareContext
{
    use DoctrineHelperTrait;

    private const FIXTURES_LOCATION = 'test/Fixtures/DatabaseSeeder/';

    /** @var  string */
    private $singleRandomId;

    /** @var  Kernel */
    protected $kernel;

    /** @var  Crawler */
    private $crawler;

    /** @var Client */
    private $client;

    private $response;

    /** @var  BeforeScenarioScope */
    private $scope;

    /** @var Registry */
    private $doctrine;

    private $postPayload;

    /** @var  CommandBus */
    private $commandBus;

    /** @var ScenarioScope */
    private $scenarioScope;

    /** @var array  */
    private $inMemoryFixtures = [];

    /**
     * @return array
     */
    public function getInMemoryFixtures() : array
    {
        return $this->inMemoryFixtures;
    }

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     * @param Registry $doctrine
     * @param $commandBus
     */
    public function __construct(
        Registry $doctrine,
        CommandBus $commandBus
    ) {
        $this->doctrine   = $doctrine;
        $this->commandBus = $commandBus;
    }

    public function getContainer() : ContainerInterface {
        return $this->kernel->getContainer();
    }

    /**
     * @param BeforeScenarioScope $scope
     * @BeforeScenario
     */
    public function before(BeforeScenarioScope $scope)
    {
        $this->client = $this->kernel->getContainer()->get('test.client');
        $this->scenarioScope = $scope;
        $this->client->setServerParameters([]);
        $this->resetScope();
    }

    /**
     * @param KernelInterface $kernelInterface
     */
    public function setKernel(KernelInterface $kernelInterface)
    {
        $this->kernel = $kernelInterface;
    }

    /**
     * @Given /^I have exactly (\d+) "([^"]*)" in the database$/
     * @param int $number
     * @param string $record
     */
    public function iHaveInTheDatabase(int $number, string $record) : void
    {
        $record = rtrim($record, 's');
        $fileLocations = [
            self::FIXTURES_LOCATION .
            ucfirst($record) . '/' . $record .
            '_x' . $number . '.yml'
        ];

        $this->createSchema();
        $this->inMemoryFixtures = $this->commandBus->handle(new LoadFixtures($fileLocations));

        $currentFixtureNumber = $this->getCurrentPostCount();
        assertTrue($currentFixtureNumber === ((int) $number));
    }

    /**
     * @Given I have default payload:
     * @param TableNode $table
     */
    public function iHaveDefaultPayload(TableNode $table) : void
    {
        $this->postPayload = $table->getNestedHash()[0];
        $pattern = '/^char[1-5]/';

        if (isset($this->postPayload['query']) && is_array($this->postPayload['query'])) {
            foreach ($this->postPayload as $key => $value) {
                if (is_array($key) === false) {
                    if (preg_match($pattern, $key) == true) {
                        $this->postPayload['query']['characterType'][] = ['type' => $this->postPayload[$key]];
                        unset($this->postPayload[$key]);
                    }
                }
            }
        }
    }

    /**
     * @When /^I request "(GET|PUT|POST|DELETE) ([^"]*)"$/
     * @param string $httpMethod
     * @param string $resource
     */
    public function iRequest(string $httpMethod, string $resource)
    {
        $this->crawler = $this->client->request($httpMethod, $resource);
        $this->response = $this->client->getResponse();
    }

    /**
     * @When /^I request "(GET|PUT|POST|DELETE) ([^"]*)" with parameters "([^"]*)"$/
     * @param string $httpMethod
     * @param string $resource
     * @param string $params
     */
    public function iRequestsWithParameters(string $httpMethod, string $resource, string $params)
    {
        $this->crawler = $this->client->request($httpMethod, $resource . $params);
        $this->response = $this->client->getResponse();
    }

    /**
     * @When /^I request "(GET|PUT|POST|DELETE) ([^"]*)" with payload$/
     * @param string $httpMethod
     * @param string $resource
     */
    public function IRequestsWithDefaultValues(string $httpMethod, string $resource)
    {
        $table = $this->postPayload;

        $this->client->followRedirects(true);

        $this->crawler = $this->client->request(
            $httpMethod,
            $resource,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($table)
        );

        $this->response = $this->client->getResponse();
    }

    /**
     * @When /^the obj "([^"]*)" has set "([^"]*)" to "([^"]*)"$/
     */
    public function theObjectHasSetItemToValue($obj, $item, $value)
    {
        if ($obj === 'query' && $item === 'characterTypes') {
            if ($value === 'missing') {
                unset($this->postPayload['query']['characterType']);
                return;
            }

            $this->postPayload['query']['characterType'] = $this->setupCharacterType($value);

            if ($value === 'less') {
                $this->postPayload['query']['characterType'] = 'yahoo';
            }
            return;
        }

        if ($obj === 'game') {
            if ($value === 'missing') {
                unset($this->postPayload['query']['game'][$item]);
                return;
            } elseif ($value === 'null') {
                $this->postPayload['query']['game'][$item] = null;
            } elseif ($value === 'false') {
                $this->postPayload['query']['game'][$item] = false;
            } elseif ($value === 'true') {
                $this->postPayload['query']['game'][$item] = true;
            } else {
                $this->postPayload['query']['game'][$item] = $value;
            }
            return;
        }
        if ($obj === 'post') {
            if ($value === 'missing') {
                unset($this->postPayload[$item]);
                return;
            } elseif ($value === 'null') {
                $this->postPayload[$item] = null;
            } elseif ($value === 'false') {
                $this->postPayload[$item] = false;
            } elseif ($value === 'true') {
                $this->postPayload[$item] = true;
            } else {
                $this->postPayload[$item] = $value;
            }
            return;
        }

        if ($value === 'missing') {
            unset($this->postPayload[$obj][$item]);
            return;
        } elseif ($value === 'null') {
            $this->postPayload[$obj][$item] = null;
        } elseif ($value === 'false') {
            $this->postPayload[$obj][$item] = false;
        } elseif ($value === 'true') {
            $this->postPayload[$obj][$item] = true;
        } else {
            $this->postPayload[$obj][$item] = $value;
        }
    }

    /**
     * @When /^the obj "([^"]*)" has set "([^"]*)" to (\d+)$/
     */
    public function theObjectHasSetItemToInteger($obj, $item, $value)
    {
        $this->postPayload[$obj][$item] = $value;
    }

    /**
     * @Then /^I get a "([^"]*)" response$/
     */
    public function iGetAResponse($statusCode)
    {
        $contentType = $this->response->headers->get('content-type');
        if ($statusCode === "200") {
            assertTrue($this->response->isOk());
        }
        assertEquals($statusCode, $this->response->getStatusCode());
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
     * @param PyStringNode $propertiesString
     */
    public function thePropertiesExist(PyStringNode $propertiesString)
    {
        foreach (explode("\n", (string) $propertiesString) as $property) {
            $this->thePropertyExists($property);
        }
    }

    /**
     * @Given /^the "([^"]*)" property exists$/
     * @param string $property
     */
    public function thePropertyExists(string $property)
    {
        assertObjectHasAttribute($property, $this->getScopePayload(), 'Missing attribute');
    }

    /**
     * @Given /^the "([^"]*)" property contains (\d+) items$/
     * @param string $property
     * @param int $count
     */
    public function thePropertyContainsItems(string $property, int $count)
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
     * @param string $property
     */
    public function thePropertyIsAnInteger(string $property)
    {
        assertInternalType('int', $this->arrayGet(
            $this->getScopePayload(),
            $property
            ),
            "Asserting the [$property] property in current scope [{$this->scope}] is an integer."
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
                $property
            ),
            "Asserting the [$property] property in current scope [{$this->scope}] is a string: ".json_encode($payload)
        );
    }

    /**
     * @Given /^the "([^"]*)" property is a string equalling "([^"]*)"$/
     * @param string $property
     * @param string $expectedValue
     */
    public function thePropertyIsAStringEqualling(string $property, string $expectedValue)
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
     * @param string $property
     */
    public function thePropertyIsAnArray(string $property)
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
     * @param $property
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
        if (! in_array($expectedValue, ['true', 'false'], true)) {
            throw new \InvalidArgumentException('Testing for booleans must be represented by [true] or [false].');
        }
        $this->thePropertyIsABoolean($property);
        assertSame(
            $actualValue,
            $expectedValue === 'true',
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
     * @Then newest items are displayed at the top
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
     * @Then /^(\d+) days old items are displayed at bottom$/
     */
    public function oldPostsAreDisplayedAtTheLastPage(int $numberOfOldPosts)
    {
        $scope = $this->getScopePayload();

        $firstItemCreatedAt = $scope->_embedded->items[0]->createdAt;
        $lastItemCreatedAt = array_pop($scope->_embedded->items)->createdAt;
        $this->resetScope();
        assertTrue($lastItemCreatedAt < $firstItemCreatedAt);
    }

    /**
     * @Given /^the "([^"]*)" property has "([^"]*)" property with "([^"]*)" getter equalling id of object in the "([^"]*)" database$/
     */
    public function thePropertyHasPropertyWithGetterEquallingIdOfObjectInTheDatabase($property, $searchProperty, $getter, $repositoryName)
    {
        $payload = $this->getScopePayload();
        $parentValue = $this->arrayGet($payload, $property);

        $actualValue = $this->arrayGet($payload, $searchProperty);
        
        $this->thePropertyIsAString($property);
        $this->thePropertyIsAString($searchProperty);

        $object = $this->dbGet($parentValue, $repositoryName);

        $searchedObject = $object->$getter;
        $expectedValue = $searchedObject->id->__toString();

        assertSame(
            $actualValue,
            (string) $expectedValue,
            "Asserting the [$property] property in current scope [{$this->scope}] is an string equalling [$expectedValue]."
        );
    }

    /**
     * @When /^payload properties (.*) equals (.*)$/
     */
    public function payloadPropertyEquals($properties, $values)
    {
        $propertiesArray = explode(',', $properties);
        $valuesArray     = explode(',', $values);
        if (count($propertiesArray) !== count($valuesArray)) {
            throw new \Exception('Properties number does not match values');
        }

        if ($this->postPayload === null) {
            throw new \Exception("Post payload is not set.");
        }
        $builders = [];
        foreach ($propertiesArray as $key => $property) {
            $data = explode('.', $property);
            $builder = '$this->postPayload';
            $valueToUnset = $data[count($data) - 2];
            $unsetBuilder = null;
            foreach ($data as $value) {
                $builder .= '["'.$value.'"]';
                if ($value === $valueToUnset) {
                    $unsetBuilder = $builder . ' = null;';
                }
            }
            if (is_numeric($valuesArray[$key])) {
                $builder .= ' = ' . $valuesArray[$key] .';';
            } else {
                $builder .= ' = "' . $valuesArray[$key] .'";';
            }
            if ($unsetBuilder !== null) {
                eval($unsetBuilder);
            }
            $builders[] = $builder;
        }
        foreach ($builders as $builder) {
            eval($builder);
        }
    }

    /**
     * @Given /^remove (.*) from payload$/
     */
    public function removeFromPayload($rproperties)
    {
        if ($rproperties === '') {
            return;
        }
        $propertiesArray = explode(',', $rproperties);
        foreach ($propertiesArray as $property) {
            [$one, $two, $three] =  explode('.', $property);
            unset($this->postPayload[$one][$two][$three]);
        }
    }

    /**
     * @Given /^I know single random id of a resource$/
     */
    public function iKnowSingleRandomIdOfAResource()
    {
        assertArrayHasKey('posts1', $this->inMemoryFixtures);
        $numberOfPostsObjectsInMemory = count(array_filter($this->inMemoryFixtures, function($object) {
            if ($object instanceof Post) {
                return $object;
            }
            return null;
        }));

        $this->singleRandomId = $this->inMemoryFixtures['posts' . random_int(1, $numberOfPostsObjectsInMemory)]->getId()->__toString();
        assertTrue($this->singleRandomId !== null);
    }

    /**
     * @When /^I request single resource "([^"]*)"(.*)$/
     */
    public function iRequestSingleResource($link)
    {
        $resource = $link . $this->singleRandomId;
        $this->crawler = $this->client->request('GET', $resource);
        $this->response = $this->client->getResponse();
    }

    /**
     * @Given /^the "([^"]*)" property is a string equalling payload id$/
     */
    public function thePropertyIsAStringEquallingPayloadId($property)
    {
        $payload = $this->getScopePayload();
        $this->thePropertyIsAString($property);
        $actualValue = $this->arrayGet($payload, $property);

        $arr = explode('/', $payload->href);
        $uuid = 'http://localhost/v1/posts/' . end($arr);
        assertSame(
            $actualValue,
            $uuid,
            "Asserting the [$property] property in current scope [{$this->scope}] is a string equalling [$uuid]."
        );
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
     * @return      mixed
     */
    protected function arrayGet($array, $key)
    {
        if (null === $key) {
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

    protected function setupCharacterType(string $value)
    {
        $arr = [];
        if (null === $value) {
            throw new \Exception();
        }

        foreach (explode(',', $value) as $cclass) {
            $arr[] = ['type' => $cclass];
        }

        return $arr;
    }

    /** @AfterScenario
     * @param AfterScenarioScope $scope
     */
    public function resetPayload(AfterScenarioScope $scope)
    {
        $this->postPayload = null;
    }
}
