<?php

namespace Reactifony\BlockBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('reactifony_block');

        $rootNode
            ->children()
                ->arrayNode('building')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('working_directory')
                            ->defaultValue('%kernel.root_dir%/cache/_reactifony')
                        ->end()
                        ->scalarNode('output_directory')
                            ->defaultValue('%kernel.root_dir%/../web')
                        ->end()
                        ->scalarNode('output_name')
                            ->defaultValue('reactifony.js')
                        ->end()
                        ->arrayNode('bundles')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('exposed')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('dependencies')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
