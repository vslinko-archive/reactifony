<?php

namespace Reactifony\BlockBundle\Block\Snapshot;

use Reactifony\BlockBundle\Block\Service\BaseBlockService;
use Reactifony\BlockBundle\Block\Service\Manager;

class Factory
{
    private $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function createSnapshot(BaseBlockService $service, $props, $childrens)
    {
        $props = $service->preprocessProps($props, $childrens);
        return new BlockSnapshot($service, $props, $childrens);
    }

    public function createSnapshotTree($blockConfig)
    {
        $service = $this->manager->getBlockService($blockConfig['block']);
        $props = $blockConfig['props'];
        $childrens = array();

        foreach ($blockConfig['children'] as $childrenConfig) {
            $childrens[] = $this->createSnapshotTree($childrenConfig);
        }

        return $this->createSnapshot($service, $props, $childrens);
    }
}
