<?php

namespace Reactifony\BlockBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Process\Process;

use Reactifony\BlockBundle\Block\Service\ClientSideBlockServiceInterface;

class BuildCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('reactifony:build')
            ->setDescription('Build block assets')
            ->addOption('watch', null, InputOption::VALUE_NONE, 'Watch for file changes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $workingDirectory = $container->getParameter('reactifony.block.building.working_directory');
        $outputDirectory = $container->getParameter('reactifony.block.building.output_directory');
        $outputName = $container->getParameter('reactifony.block.building.output_name');
        $bundles = $container->getParameter('reactifony.block.building.bundles');
        $exposed = array_merge(
            array('React' => 'react'),
            $container->getParameter('reactifony.block.building.exposed')
        );

        if (!file_exists($workingDirectory)) {
            $command = $this->getApplication()->find('reactifony:install');
            $command->run(new ArrayInput(array('')), $output);
        }

        $kernel = $this->getContainer()->get('kernel');
        foreach ($bundles as $name) {
            if (!file_exists($workingDirectory.'/'.$name)) {
                symlink($kernel->locateResource($name.'/Resources/webpack'), $workingDirectory.'/'.$name);
            }
        }

        $webpackConfig = array(
            'entry' => './reactifony',
            'output' => array(
                'path' => $outputDirectory,
                'filename' => $outputName,
            ),
        );

        $manager = $this->getContainer()->get('reactifony.block.service.manager');
        $services = $manager->getBlockServices();
        $services = array_filter($services, function($service) {
            return $service instanceof ClientSideBlockServiceInterface;
        });

        $reactifonyFile = '';
        foreach ($exposed as $var => $module) {
            $reactifonyFile .= 'window.'.$var.' = require("'.$module.'");'."\n";
        }
        $reactifonyFile .= 'var __reactified_modules__ = {';
        $reactifonyFile .= implode(',', array_map(function($service) {
            $name = $service->getClientSideModuleName();
            return '"'.$name.'": require("./'.$name.'")';
        }, $services));
        $reactifonyFile .= '};'."\n";
        $reactifonyFile .= 'window.reactifony = function(name) {';
        $reactifonyFile .= 'return __reactified_modules__[name];';
        $reactifonyFile .= '};';
        file_put_contents($workingDirectory.'/reactifony.js', $reactifonyFile);

        $webpackConfigFile = 'var webpack = require("webpack");';
        $webpackConfigFile .= 'module.exports={';
        $webpackConfigFile .= 'entry:'.json_encode($webpackConfig['entry']).',';
        $webpackConfigFile .= 'output:'.json_encode($webpackConfig['output']).',';
        $webpackConfigFile .= 'module:{loaders:[';
        $webpackConfigFile .= '{test:/\.js$/, loader: "jsx", exclude: /node_modules/}';
        $webpackConfigFile .= ']}';
        $webpackConfigFile .= '};';

        file_put_contents($workingDirectory.'/webpack.config.js', $webpackConfigFile);

        $command = array($workingDirectory.'/node_modules/.bin/webpack');
        if ($input->getOption('watch')) {
            $command[] = '--watch';
        }

        $process = new Process(implode(' ', $command));
        $process->setTimeout(null);
        $process->setWorkingDirectory($workingDirectory);
        $process->run(function($type, $buffer) {
            echo $buffer;
        });
    }
}
