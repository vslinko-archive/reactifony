<?php

namespace Reactifony\BlockBundle\Block\Snapshot;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Reactifony\BlockBundle\Block\Service\ClientSideBlockServiceInterface;

class Renderer
{
    private $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    public function render(BlockSnapshot $snapshot)
    {
        if ($snapshot->getService() instanceof ClientSideBlockServiceInterface) {
            return $this->renderClientSideBlock($snapshot);
        } else {
            return $this->renderServerSideBlock($snapshot);
        }
    }

    private function renderClientSideBlock(BlockSnapshot $snapshot)
    {
        $result = '<div id="reactifony'.$snapshot->getHash().'"></div>';
        $result .= '<script>';
        $result .= 'React.renderComponent(';
        $result .= $this->renderClientSideBlockModuleCall($snapshot);
        $result .= ',document.getElementById("reactifony'.$snapshot->getHash().'"));';
        $result .= '</script>';

        return $result;
    }

    private function renderClientSideBlockModuleCall($snapshot)
    {
        $result = 'reactifony("'.$snapshot->getService()->getClientSideModuleName().'")(';
        $result .= json_encode($snapshot->getProps());

        foreach ($snapshot->getChildrens() as $children) {
            $result .= ',';

            if ($children->getService() instanceof ClientSideBlockServiceInterface) {
                $result .= $this->renderClientSideBlockModuleCall($children, false);
            } else {
                $result .= 'React.DOM.div({dangerouslySetInnerHTML: {__html:';
                $result .= json_encode($this->renderServerSideBlock($children));
                $result .= '}})';
            }
        }

        $result .= ')';

        return $result;
    }

    private function renderServerSideBlock(BlockSnapshot $snapshot)
    {
        $template = $snapshot->getService()->getTemplate();
        $props = $snapshot->getProps();
        $props['childrens'] = $snapshot->getChildrens();
        return $this->templating->render($template, $props);
    }
}
