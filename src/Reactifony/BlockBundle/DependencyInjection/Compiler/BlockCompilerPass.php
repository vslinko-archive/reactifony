<?php

namespace Reactifony\BlockBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class BlockCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('reactifony.block.service.manager')) {
            return;
        }

        $definition = $container->getDefinition(
            'reactifony.block.service.manager'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'reactifony.block.service'
        );

        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall(
                    'addBlockService',
                    array(new Reference($id))
                );
            }
        }
    }
}
