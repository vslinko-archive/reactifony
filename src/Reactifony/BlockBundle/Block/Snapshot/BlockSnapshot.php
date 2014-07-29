<?php

namespace Reactifony\BlockBundle\Block\Snapshot;

use Reactifony\BlockBundle\Block\Service\BlockServiceInterface;

class BlockSnapshot
{
    private static $counter = 0;

    private $service;
    private $props;
    private $childrens;
    private $hash;

    public function __construct(BlockServiceInterface $service, $props, $childrens)
    {
        $this->service = $service;
        $this->props = $props;
        $this->childrens = $childrens;
        $this->hash = self::$counter++;
    }

    public function getService()
    {
        return $this->service;
    }

    public function getProps()
    {
        return $this->props;
    }

    public function getChildrens()
    {
        return $this->childrens;
    }

    public function getHash()
    {
        return $this->hash;
    }
}
