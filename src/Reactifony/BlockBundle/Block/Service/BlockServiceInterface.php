<?php

namespace Reactifony\BlockBundle\Block\Service;

interface BlockServiceInterface
{
    public function getName();

    public function preprocessProps($props, $childrens);
}
