<?php

namespace RiftRunBundle\CommandBus\Pipelines;

use InvalidArgumentException;
use League\Pipeline\PipelineBuilder;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Throwable;

class PipelineManager implements PipelineManagerInterface, ContainerAwareInterface
{
    /** @var PipelineBuilder  */
    private $pipelineBuilder;

    /** @var array */
    private $mappedCriteria;

    /** @var  ContainerInterface */
    private $container;

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
                        if ($this->container->has($dependency)) {
                            $dep = $this->container->get($dependency);
                            $pipeline = new $this->mappedCriteria[$criteria]($dep);
                        } else {
                            $pipeline = new $this->mappedCriteria[$criteria](new $dependency);
                        }
                    } else {
                        $pipeline = new $this->mappedCriteria[$criteria]();
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

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}