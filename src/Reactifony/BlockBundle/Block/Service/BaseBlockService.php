<?php

namespace Reactifony\BlockBundle\Block\Service;

use Reactifony\BlockBundle\Block\Snapshot\Factory;

abstract class BaseBlockService implements BlockServiceInterface
{
    public function preprocessProps($props, $childrens)
    {
        return $props;
    }
}
