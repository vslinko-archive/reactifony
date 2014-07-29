<?php

namespace Reactifony\BlockBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Reactifony\BlockBundle\DependencyInjection\Compiler\BlockCompilerPass;

class ReactifonyBlockBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new BlockCompilerPass());
    }
}
