<?php

namespace Reactifony\BlockBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class ReactifonyBlockExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('reactifony.block.building.working_directory', $config['building']['working_directory']);
        $container->setParameter('reactifony.block.building.output_directory', $config['building']['output_directory']);
        $container->setParameter('reactifony.block.building.output_name', $config['building']['output_name']);
        $container->setParameter('reactifony.block.building.bundles', $config['building']['bundles']);
        $container->setParameter('reactifony.block.building.exposed', $config['building']['exposed']);
        $container->setParameter('reactifony.block.building.dependencies', $config['building']['dependencies']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
