<?php

namespace Reactifony\BlockBundle\Block\Service;

class Manager
{
    private $blockServices = array();

    public function addBlockService(BlockServiceInterface $service)
    {
        $this->blockServices[$service->getName()] = $service;
    }

    public function getBlockServices()
    {
        return $this->blockServices;
    }

    public function getBlockService($name)
    {
        if (!array_key_exists($name, $this->blockServices)) {
            return null;
        }

        return $this->blockServices[$name];
    }
}
