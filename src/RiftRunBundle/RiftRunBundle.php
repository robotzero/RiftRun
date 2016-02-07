<?php

namespace RiftRunBundle;

use RiftRunBundle\DependencyInjection\Compiler\ListenersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RiftRunBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ListenersPass());
    }
}
