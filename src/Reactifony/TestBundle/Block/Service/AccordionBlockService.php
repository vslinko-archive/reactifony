<?php

namespace Reactifony\TestBundle\Block\Service;

use Reactifony\BlockBundle\Block\Service\BaseBlockService;
use Reactifony\BlockBundle\Block\Service\ClientSideBlockServiceInterface;

class AccordionBlockService extends BaseBlockService implements ClientSideBlockServiceInterface
{
    public function getClientSideModuleName()
    {
        return '@ReactifonyTestBundle/Accordion';
    }

    public function getName()
    {
        return 'Accordion';
    }
}
