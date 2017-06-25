<?php

namespace Test\Integration\Context;

use Coduo\PHPMatcher\Matcher;
use Symfony\Component\HttpFoundation\Response;
use Test\Integration\Helpers\MatcherFactory;

abstract class JsonApiContext extends NewApiContext
{
    /**
     * @before
     */
    public function setUpClient(): void
    {
        $this->client = static::createClient(array(), array('HTTP_ACCEPT' => 'application/json'));
    }

    /**
     * {@inheritdoc}
     */
    protected function buildMatcher(): Matcher
    {
        return MatcherFactory::buildJsonMatcher();
    }

    /**
     * Asserts that response has JSON content.
     * If filename is set, asserts that response content matches the one in given file.
     * If statusCode is set, asserts that response has given status code.
     *
     * @param Response $response
     * @param string|null $filename
     * @param int|null $statusCode
     *
     * @throws \Exception
     */
    protected function assertResponse(Response $response, $filename, $statusCode = 200): void
    {
        if (isset($_SERVER['OPEN_ERROR_IN_BROWSER']) && true === $_SERVER['OPEN_ERROR_IN_BROWSER']) {
            $this->showErrorInBrowserIfOccurred($response);
        }

        $this->assertResponseCode($response, $statusCode);
        $this->assertJsonHeader($response);
        $this->assertJsonResponseContent($response, $filename);
    }

    /**
     * @param Response $response
     */
    private function assertJsonHeader(Response $response): void
    {
        parent::assertHeader($response, 'application/json');
    }

    /**
     * Asserts that response has JSON content matching the one given in file.
     *
     * @param Response $response
     * @param string $filename
     *
     * @throws \Exception
     */
    private function assertJsonResponseContent(Response $response, $filename): void
    {
        parent::assertResponseContent($this->prettifyJson($response->getContent()), $filename, 'json');
    }

    /**
     * @param $content
     *
     * @return string
     */
    private function prettifyJson($content): string
    {
        return json_encode(json_decode($content), JSON_PRETTY_PRINT);
    }
}
