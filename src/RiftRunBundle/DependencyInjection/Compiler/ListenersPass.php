<?php

namespace RiftRunBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ListenersPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds('tactician.listener');

        if (count($taggedServices) === 0) {
            return;
        }

        $container->setDefinition('default_event_dispatcher', new Definition(
            'Symfony\Component\EventDispatcher\EventDispatcher'
        ));

        $eventDispatcher = $container->getDefinition('default_event_dispatcher');
        foreach ($container->findTaggedServiceIds('tactician.listener') as $id => $tags) {
            $currentListener = $container->getDefinition($id);

            foreach ($tags as $attributes) {
                if (!isset($attributes['event'])) {
                    throw new \Exception('Please provide an event name!');
                }
                $eventDispatcher->addMethodCall('addListener', [ $attributes['event'], [ $currentListener, $attributes['method']]]);
            }
        }
    }
}