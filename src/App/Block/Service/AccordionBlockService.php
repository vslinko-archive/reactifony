<?php

namespace App\Block\Service;

use Reactifony\BlockBundle\Block\Service\BaseBlockService;
use Reactifony\BlockBundle\Block\Service\ClientSideBlockServiceInterface;

class AccordionBlockService extends BaseBlockService implements ClientSideBlockServiceInterface
{
    public function getClientSideModuleName()
    {
        return '@App/Accordion';
    }

    public function getName()
    {
        return 'Accordion';
    }
}
