<?php

namespace Test\Integration\Context;

use Coduo\PHPMatcher\Matcher;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Fidry\AliceDataFixtures\LoaderInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ResettableContainerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\HttpKernel\Kernel;
use Test\Integration\Helpers\PathBuilder;

abstract class NewApiContext extends WebTestCase
{
    /**
     * @var Kernel
     */
    protected static $sharedKernel;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $expectedResponsesPath;

    /**
     * @var string
     */
    protected $mockedResponsesPath;

    /**
     * @var string
     */
    protected $dataFixturesPath;

    /**
     * @var LoaderInterface
     */
    private $fixtureLoader;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @beforeClass
     */
    public static function createSharedKernel(): void
    {
        static::$sharedKernel = static::createKernel(['debug' => false]);
        static::$sharedKernel->boot();
    }

    /**
     * @afterClass
     */
    public static function ensureSharedKernelShutdown(): void
    {
        if (null !== static::$sharedKernel) {
            $container = static::$sharedKernel->getContainer();
            static::$sharedKernel->shutdown();
            if ($container instanceof ResettableContainerInterface) {
                $container->reset();
            }
        }
    }

    /**
     * @before
     */
    public function setUpClient(): void
    {
        $this->client = static::createClient(['debug' => false]);
    }

    /**
     * @before
     */
    public function setUpDatabase(): void
    {
        $this->entityManager = static::$sharedKernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->entityManager->getConnection()->connect();
        $this->fixtureLoader = static::$sharedKernel->getContainer()->get('fidry_alice_data_fixtures.doctrine.persister_loader');

        $this->purgeDatabase();
    }

    public function tearDown(): void
    {
        if (null !== $this->client && null !== $this->client->getContainer()) {
            foreach ($this->client->getContainer()->getMockedServices() as $id => $service) {
                $this->client->getContainer()->unmock($id);
            }
        }
//        \Mockery::close();
        $this->client = null;
        $this->entityManager = null;
        $this->fixtureLoader = null;
        parent::tearDown();
    }

    /**
     * @return Matcher
     */
    abstract protected function buildMatcher(): Matcher;

    /**
     * return ProcessorInterface[]
     */
    protected function getFixtureProcessors(): array
    {
        return [];
    }

    /**
     * @return string
     */
    protected static function getKernelClass(): string
    {
        if (isset($_SERVER['KERNEL_CLASS'])) {
            return '\\' . ltrim($_SERVER['KERNEL_CLASS'], '\\');
        }
        if (isset($_SERVER['KERNEL_CLASS_PATH'])) {
            $paths = [
                $_SERVER['KERNEL_CLASS_PATH'],
                static::getPhpUnitXmlDir() . DIRECTORY_SEPARATOR . $_SERVER['KERNEL_CLASS_PATH']
            ];
            foreach ($paths as $path) {
                if (file_exists($path)) {
                    require_once $path;
                    return '\\' . (new \SplFileInfo($path))->getBasename('.php');
                }
            }
        }
        return parent::getKernelClass();
    }

    protected function purgeDatabase(): void
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
        $this->getEntityManager()->clear();
    }

    /**
     * Gets service from DIC.
     *
     * @param string $id
     *
     * @return object
     */
    protected function get($id): Object
    {
        return $this->client->getContainer()->get($id);
    }

    /**
     * @param Response $response
     * @param int $statusCode
     */
    protected function assertResponseCode(Response $response, $statusCode): void
    {
        self::assertEquals($statusCode, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @param Response $response
     * @param string $contentType
     */
    protected function assertHeader(Response $response, $contentType): void
    {
        self::assertTrue(
            $response->headers->contains('Content-Type', $contentType),
            $response->headers
        );
    }

    /**
     * @param string $actualResponse
     * @param string $filename
     * @param string $mimeType
     */
    protected function assertResponseContent($actualResponse, $filename, $mimeType): void
    {
        $responseSource = $this->getExpectedResponsesFolder();
        $actualResponse = trim($actualResponse);
        $expectedResponse = trim(file_get_contents(PathBuilder::build($responseSource, sprintf('%s.%s', $filename, $mimeType))));
        $matcher = $this->buildMatcher();
        $result = $matcher->match($actualResponse, $expectedResponse);
        if (!$result) {
            $diff = new \Diff(explode(PHP_EOL, $expectedResponse), explode(PHP_EOL, $actualResponse), []);
            self::fail($matcher->getError() . PHP_EOL . $diff->render(new \Diff_Renderer_Text_Unified()));
        }
    }

    /**
     * @param Response $response
     *
     * @throws \Exception
     */
    protected function showErrorInBrowserIfOccurred(Response $response): void
    {
        if (!$response->isSuccessful()) {
            $openCommand = $_SERVER['OPEN_BROWSER_COMMAND'] ?? 'open %s';
            $tmpDir = $_SERVER['TMP_DIR'] ?? sys_get_temp_dir();

            $filename = PathBuilder::build(rtrim($tmpDir, \DIRECTORY_SEPARATOR), uniqid('', true) . '.html');
            file_put_contents($filename, $response->getContent());
            system(sprintf($openCommand, escapeshellarg($filename)));
            throw new \Exception('Internal server error.');
        }
    }

    /**
     * Provides array from decoded json file. Requires MOCKED_RESPONSE_DIR defined variable to work properly.
     *
     * @param string $filename
     *
     * @return array
     *
     * @throws \Exception
     */
    protected function getJsonResponseFixture($filename): array
    {
        $responseSource = $this->getMockedResponsesFolder();
        return json_decode(file_get_contents(PathBuilder::build($responseSource, $filename . '.json')), true);
    }

    /**
     * @param string $source
     *
     * @return array
     */
    protected function loadFixturesFromDirectory($source = ''): array
    {
        $source = $this->getFixtureRealPath($source);
        $this->assertSourceExists($source);
        $finder = new Finder();
        $finder->files()->name('*.yml')->in($source);
        if (0 === $finder->count()) {
            throw new \RuntimeException(sprintf('There is no files to load in folder %s', $source));
        }
        $files = [];
        foreach ($finder as $file) {
            $files[] = $file->getRealPath();
        }
        return $this->getFixtureLoader()->load($files);
    }

    /**
     * @param string $source
     *
     * @return array
     */
    protected function loadFixturesFromFile($source): array
    {
        $source = $this->getFixtureRealPath($source);
        $this->assertSourceExists($source);

        return $this->getFixtureLoader()->load([$source]);
    }

    /**
     * @return LoaderInterface
     */
    protected function getFixtureLoader(): LoaderInterface
    {
        if (null === $this->fixtureLoader) {
            throw new \RuntimeException('Please, set up a database before you will try to use a fixture loader');
        }
        return $this->fixtureLoader;
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager(): EntityManager
    {
        if (null === $this->entityManager || !$this->entityManager->getConnection()->isConnected()) {
            static::fail('Could not establish test database connection.');
        }
        return $this->entityManager;
    }

    /**
     * @param string $source
     *
     * @return string
     */
    private function getFixtureRealPath($source): string
    {
        $baseDirectory = $this->getFixturesFolder();
        return PathBuilder::build($baseDirectory, $source);
    }

    /**
     * @return string
     */
    private function getFixturesFolder(): string
    {
        if (null === $this->dataFixturesPath) {
            $this->dataFixturesPath = isset($_SERVER['FIXTURES_DIR']) ?
                PathBuilder::build($this->getRootDir(), $_SERVER['FIXTURES_DIR'] ) :
                PathBuilder::build($this->getCalledClassFolder(), '..', 'DataFixtures', 'ORM');
        }
        return $this->dataFixturesPath;
    }

    /**
     * @return string
     */
    private function getExpectedResponsesFolder(): string
    {
        if (null === $this->expectedResponsesPath) {
            $this->expectedResponsesPath = isset($_SERVER['EXPECTED_RESPONSE_DIR']) ?
                PathBuilder::build($this->getRootDir(), $_SERVER['EXPECTED_RESPONSE_DIR']) :
                PathBuilder::build($this->getCalledClassFolder(), '..', 'Responses', 'Expected');
        }
        return $this->expectedResponsesPath;
    }

    /**
     * @return string
     */
    private function getMockedResponsesFolder(): string
    {
        if (null === $this->mockedResponsesPath) {
            $this->mockedResponsesPath = isset($_SERVER['MOCKED_RESPONSE_DIR']) ?
                PathBuilder::build($this->getRootDir(), $_SERVER['MOCKED_RESPONSE_DIR']) :
                PathBuilder::build($this->getCalledClassFolder(), '..', 'Responses', 'Mocked');
        }
        return $this->mockedResponsesPath;
    }

    /**
     * @return string
     */
    private function getCalledClassFolder(): string
    {
        $calledClass = get_called_class();
        $calledClassFolder = dirname((new \ReflectionClass($calledClass))->getFileName());
        $this->assertSourceExists($calledClassFolder);
        return $calledClassFolder;
    }

    /**
     * @param string $source
     */
    private function assertSourceExists($source): void
    {
        if (!file_exists($source)) {
            throw new \RuntimeException(sprintf('File %s does not exist', $source));
        }
    }

    /**
     * @return string
     */
    private function getRootDir(): string
    {
        return $this->get('kernel')->getRootDir();
    }
}