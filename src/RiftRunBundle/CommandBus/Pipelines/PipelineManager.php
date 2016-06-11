<?php

namespace RiftRunBundle\CommandBus\Pipelines;

use InvalidArgumentException;
use League\Pipeline\PipelineBuilder;
use Symfony\Component\Form\FormFactoryInterface;
use Throwable;

class PipelineManager implements PipelineManagerInterface
{
    /** @var PipelineBuilder  */
    private $pipelineBuilder;

    /** @var array */
    private $mappedCriteria;

    public function __construct(PipelineBuilder $pipelineBuilder, array $mappedCriteria = [])
    {
        $this->pipelineBuilder = $pipelineBuilder;
        $this->mappedCriteria = $mappedCriteria;
    }

    /** @inheritdoc */
    public function build(array $buildCriteria = [])
    {
        if (count($buildCriteria) === 0) {
            return $this->pipelineBuilder->build();
        }
        $pipelines = [];

        foreach ($buildCriteria as $criteria => $dependency) {
            if (array_key_exists($criteria, $this->mappedCriteria)) {
                try {
                    if ($dependency !== null) {
                        $pipeline = new $this->mappedCriteria[$criteria](new $dependency);
                    } else {
                        $pipeline = new $this->mappedCriteria[$criteria];
                    }
                    $pipelines[] = $pipeline;
                } catch (Throwable $e) {
                    throw new InvalidArgumentException('Unable to instantiate pipeline: ' . $e->getMessage());
                }
            }
        }

        if (count($pipelines) === 0 || count($pipelines) !== count($buildCriteria)) {
            throw new InvalidArgumentException('Invalid pipeline.');
        }

        foreach ($pipelines as $pipeline) {
            $this->pipelineBuilder->add($pipeline);
        }

        return $this->pipelineBuilder->build();
    }
}