<?php

namespace Reactifony\BlockBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ReactifonyExtension extends \Twig_Extension
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'reactifony',
                array($this, 'reactifonyFunction'),
                array('is_safe' => array('html'))
            ),
        );
    }

    public function reactifonyFunction($blockConfig)
    {
        $factory = $this->container->get('reactifony.block.snapshot.factory');
        $renderer = $this->container->get('reactifony.block.snapshot.renderer');

        return $renderer->render($factory->createSnapshotTree($blockConfig));
    }

    public function getName()
    {
        return 'reactifony';
    }
}
