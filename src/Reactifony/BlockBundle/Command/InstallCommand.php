<?php

namespace Reactifony\BlockBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

use Reactifony\BlockBundle\Block\Service\ClientSideBlockServiceInterface;

class InstallCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('reactifony:install')
            ->setDescription('Install blocks dependencies')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $workingDirectory = $container->getParameter('reactifony.block.building.working_directory');
        $dependencies = array(
            'react' => '~0.11',
            'webpack' => '~1.3',
            'jsx-loader' => '~0.11',
        );
        $dependencies = array_merge(
            $dependencies,
            $container->getParameter('reactifony.block.building.dependencies')
        );

        if (!file_exists($workingDirectory)) {
            mkdir($workingDirectory);
        }

        file_put_contents($workingDirectory.'/package.json', json_encode(array(
            'name' => 'reactifony',
            'version' => '1.0.0',
            'description' => 'Reactifony building package',
            'repository' => 'none',
            'dependencies' => $dependencies,
        )));

        file_put_contents($workingDirectory.'/README.md', '# Reactifony building package');

        $process = new Process('npm install');
        $process->setWorkingDirectory($workingDirectory);
        $process->run(function($type, $buffer) {
            echo $buffer;
        });
    }
}
