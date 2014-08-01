<?php

namespace App\Block\Service;

use Reactifony\BlockBundle\Block\Service\BaseBlockService;
use Reactifony\BlockBundle\Block\Service\ClientSideBlockServiceInterface;

class DocumentsBlockService extends BaseBlockService implements ClientSideBlockServiceInterface
{
    public function getClientSideModuleName()
    {
        return '@App/Documents';
    }

    public function getName()
    {
        return 'Documents';
    }
}
