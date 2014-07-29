<?php

namespace Reactifony\TestBundle\Block\Service;

use Reactifony\BlockBundle\Block\Service\BaseBlockService;
use Reactifony\BlockBundle\Block\Service\ClientSideBlockServiceInterface;

class DocumentsBlockService extends BaseBlockService implements ClientSideBlockServiceInterface
{
    public function getClientSideModuleName()
    {
        return '@ReactifonyTestBundle/Documents';
    }

    public function getName()
    {
        return 'Documents';
    }
}
