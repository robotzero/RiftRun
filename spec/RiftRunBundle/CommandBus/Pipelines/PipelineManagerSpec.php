<?php

namespace spec\RiftRunBundle\CommandBus\Pipelines;

use InvalidArgumentException;
use League\Pipeline\Pipeline;
use League\Pipeline\PipelineBuilder;
use RiftRunBundle\CommandBus\Pipelines\PipelineManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PipelineManagerSpec extends ObjectBehavior
{
    private $container;

    function let(PipelineBuilder $pipelineBuilder, ContainerInterface $container)
    {
        $fixtureCriteria = [
            'default' => Pipeline::class,
            'testPipelineA' => TestPipelineA::class,
            'testPipelineB' => TestPipelineB::class,
            'testPipelineC' => TestPipelineC::class,
            'testPipelineD' => TestPipelineD::class,
            'testPipelineE' => TestPipelineE::class,
            'nonExistingClass' => Test::class
        ];

        $this->beConstructedWith($pipelineBuilder, $fixtureCriteria);
        $this->setContainer($container);
        $this->container = $container;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PipelineManager::class);
    }

    function it_should_implement_and_interface()
    {
        $this->shouldImplement('RiftRunBundle\CommandBus\Pipelines\PipelineManagerInterface');
    }

    function it_builds_returns_pipeline_by_default(PipelineBuilder $pipelineBuilder)
    {
        $pipelineBuilder->build()->shouldBeCalledTimes(1);
        $pipelineBuilder->build()->willReturn(new Pipeline());
        $this->build()->shouldReturnAnInstanceOf('League\Pipeline\Pipeline');
    }

    function it_builds_pipeline_with_one_criteria(PipelineBuilder $pipelineBuilder)
    {
        $pipelineBuilder->add(new TestPipelineA())->shouldBeCalledTimes(1);
        $pipelineBuilder->build()->willReturn(new Pipeline());
        $this->build(['testPipelineA' => null])->shouldReturnAnInstanceOf('League\Pipeline\Pipeline');
    }

    function it_builds_pipeline_with_more_than_one_criteria(PipelineBuilder $pipelineBuilder)
    {
        $pipelineBuilder->add(new TestPipelineA())->shouldBeCalledTimes(1);
        $pipelineBuilder->add(new TestPipelineB())->shouldBeCalledTimes(1);
        $pipelineBuilder->build()->willReturn(new Pipeline());
        $this->build(['testPipelineA' => null, 'testPipelineB' => null])->shouldReturnAnInstanceOf('League\Pipeline\Pipeline');
    }

    function it_builds_one_pipeline_with_a_provided_class_dependency(PipelineBuilder $pipelineBuilder)
    {
        $pipelineBuilder->add(new TestPipelineC(new Dependency()))->shouldBeCalledTimes(1);
        $pipelineBuilder->build()->willReturn(new Pipeline());
        $this->build(['testPipelineC' => Dependency::class])->shouldReturnAnInstanceOf('League\Pipeline\Pipeline');
    }

    function it_builds_one_pipeline_with_a_provided_container_dependency(PipelineBuilder $pipelineBuilder)
    {
        $fakeService = new FakeService();
        $this->container->has('some.service')->willReturn(true);
        $this->container->get('some.service')->willReturn($fakeService);
        $pipelineBuilder->add(new TestPipelineE($fakeService))->shouldBeCalledTimes(1);
        $pipelineBuilder->build()->willReturn(new Pipeline());
        $this->build(['testPipelineE' => 'some.service'])->shouldReturnAnInstanceOf('League\Pipeline\Pipeline');
    }

    function it_builds_pipelines_with_depedency_class_and_container_dependency(PipelineBuilder $pipelineBuilder)
    {
        $fakeService = new FakeService();
        $this->container->get('some.service')->willReturn($fakeService);
        $this->container->has('some.service')->willReturn(true);
        $pipelineBuilder->add(new TestPipelineE($fakeService))->shouldBeCalledTimes(1);
        $this->container->has('spec\RiftRunBundle\CommandBus\Pipelines\Dependency')->willReturn(false);
        $pipelineBuilder->add(new TestPipelineC(new Dependency()))->shouldBeCalledTimes(1);
        $pipelineBuilder->build()->willReturn(new Pipeline());
        $this->build(['testPipelineE' => 'some.service', 'testPipelineC' => Dependency::class])->shouldReturnAnInstanceOf('League\Pipeline\Pipeline');
    }

    function it_builds_pipelines_with_dependency_class_container_dependency_and_no_dependency(PipelineBuilder $pipelineBuilder)
    {
        $fakeService = new FakeService();
        $this->container->get('some.service')->willReturn($fakeService);
        $this->container->has('some.service')->willReturn(true);
        $pipelineBuilder->add(new TestPipelineE($fakeService))->shouldBeCalledTimes(1);
        $this->container->has('spec\RiftRunBundle\CommandBus\Pipelines\Dependency')->willReturn(false);
        $pipelineBuilder->add(new TestPipelineC(new Dependency()))->shouldBeCalledTimes(1);
        $pipelineBuilder->add(new TestPipelineA())->shouldBeCalledTimes(1);
        $pipelineBuilder->build()->willReturn(new Pipeline());
        $this->build(['testPipelineE' => 'some.service', 'testPipelineC' => Dependency::class, 'testPipelineA' => null])->shouldReturnAnInstanceOf('League\Pipeline\Pipeline');
    }

    function it_throws_an_exception_when_criteria_does_not_match_any_configured_pipelines()
    {
        $this->shouldThrow(new InvalidArgumentException('Invalid pipeline.'))->during('build', [['nonExistingPipeline' => null]]);
    }

    function it_throws_an_exception_when_criteria_does_match_one_pipe()
    {
        $this->shouldThrow(new InvalidArgumentException('Invalid pipeline.'))->during(
            'build',
            [
                ['nonExistingPipeline' => null, 'testPipelineA' => null]
            ]
        );
    }

    function it_throws_an_exception_when_criteria_cant_be_instantiated()
    {
        $this->shouldThrow(new InvalidArgumentException('Unable to instantiate pipeline: Class \'spec\RiftRunBundle\CommandBus\Pipelines\Test\' not found'))->during(
            'build',
            [
                ['nonExistingClass' => null]
            ]
        );
    }

    function it_throws_an_exception_when_pipeline_dependency_cant_be_instantiated()
    {
        $this->shouldThrow(new InvalidArgumentException('Unable to instantiate pipeline: Class \'spec\RiftRunBundle\CommandBus\Pipelines\NonExistingDependency\' not found'))->during(
            'build',
            [
                ['testPipelineA' => null, 'testPipelineC' => Dependency::class, 'testPipelineD' => NonExistingDependency::class]
            ]
        );
    }

    function it_throws_an_exception_when_pipeline_container_dependency_cant_be_found(PipelineBuilder $pipelineBuilder)
    {
        $this->container->has('spec\RiftRunBundle\CommandBus\Pipelines\Dependency')->willReturn(true);
        $this->container->get('spec\RiftRunBundle\CommandBus\Pipelines\Dependency')->willReturn(new Dependency());
        $this->container->has('service.does.not.exist')->willReturn(false);
        $this->shouldThrow(new InvalidArgumentException('Unable to instantiate pipeline: Class \'service.does.not.exist\' not found'))->during(
            'build',
            [
                ['testPipelineA' => null, 'testPipelineC' => Dependency::class, 'testPipelineE' => 'service.does.not.exist']
            ]
        );
    }
}

class TestPipelineA { public function __invoke() {}}
class TestPipelineB { public function __invoke() {}}
class TestPipelineC { public function __construct(Dependency $dependency) {} public function __invoke() {}}
class TestPipelineD { public function __construct(Dependency $dependency) {} public function __invoke() {}}
class TestPipelineE { public function __construct(FakeService $fakeservice) {} public function __invoke() {}}
class Dependency {};
class FakeService {};
