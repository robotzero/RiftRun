<?php

namespace Test\Integration\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Symfony\Component\HttpKernel\KernelInterface;

require_once __DIR__.'/../../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements KernelAwareContext, Context, SnippetAcceptingContext
{
    protected $kernel;

    private $crawler = null;

    private $client = null;

    private $response = null;

    private $scope = null;

    // TODO load custom fixtures.

    /** @BeforeScenario */
    public function before(BeforeScenarioScope $scope)
    {
        $this->client = $this->kernel->getContainer()->get('test.client');
        $this->client->setServerParameters([]);
    }

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {

    }
    public function setKernel(KernelInterface $kernelInterface)
    {
        $this->kernel = $kernelInterface;
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
        isType(
            'int',
            $this->arrayGet($this->getScopePayload(), $property),
            "Asserting the [$property] property in current scope [{$this->scope}] is an integer: "
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
        isType(
            'string',
            $this->arrayGet($payload, $property),
            "Asserting the [$property] property in current scope [{$this->scope}] is a string: ".json_encode($payload)
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
     * @Given /^the "([^"]*)" property is an object$/
     */
    public function thePropertyIsAnObject($property)
    {
        print_r($property);
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
}
