<?php

namespace spec\RiftRunBundle\CommandBus\Pipelines;

use InvalidArgumentException;
use League\Pipeline\Pipeline;
use League\Pipeline\PipelineBuilder;
use RiftRunBundle\CommandBus\Pipelines\PipelineManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PipelineManagerSpec extends ObjectBehavior
{
    function let(PipelineBuilder $pipelineBuilder)
    {
        $fixtureCriteria = [
            'default' => Pipeline::class,
            'testPipelineA' => TestPipelineA::class,
            'testPipelineB' => TestPipelineB::class,
            'nonExistingClass' => Test::class
        ];

        $this->beConstructedWith($pipelineBuilder, $fixtureCriteria);
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
        $this->build(['testPipelineA'])->shouldReturnAnInstanceOf('League\Pipeline\Pipeline');
    }

    function it_builds_pipeline_with_more_than_one_criteria(PipelineBuilder $pipelineBuilder)
    {
        $pipelineBuilder->add(new TestPipelineA())->shouldBeCalledTimes(1);
        $pipelineBuilder->add(new TestPipelineB())->shouldBeCalledTimes(1);
        $pipelineBuilder->build()->willReturn(new Pipeline());
        $this->build(['testPipelineA', 'testPipelineB'])->shouldReturnAnInstanceOf('League\Pipeline\Pipeline');
    }

    function it_throws_an_exception_when_criteria_does_not_match_any_configured_pipelines()
    {
        $this->shouldThrow(new InvalidArgumentException('Invalid pipeline.'))->during('build', [['nonExistingPipeline']]);
    }

    function it_throws_an_exception_when_criteria_does_match_one_pipe()
    {
        $this->shouldThrow(new InvalidArgumentException('Invalid pipeline.'))->during(
            'build',
            [
                ['nonExistingPipeline', 'testPipelineA']
            ]
        );
    }

    function it_throws_an_exception_when_criteria_cant_be_instantiated()
    {
        $this->shouldThrow(new InvalidArgumentException('Invalid pipeline.'))->during(
            'build',
            [
                ['nonExistingClass']
            ]
        );
    }
}

class TestPipelineA { public function __invoke() {}}
class TestPipelineB { public function __invoke() {}}
