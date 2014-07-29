<?php

namespace Reactifony\TestBundle\Block\Service;

use Reactifony\BlockBundle\Block\Service\BaseBlockService;
use Reactifony\BlockBundle\Block\Service\ServerSideBlockServiceInterface;

class TextBlockService extends BaseBlockService implements ServerSideBlockServiceInterface
{
    public function getTemplate()
    {
        return 'ReactifonyTestBundle:Block:text.html.twig';
    }

    public function getName()
    {
        return 'Text';
    }
}
