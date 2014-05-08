<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\Block\BlockInterface;
use Midnight\Block\Renderer\RendererInterface;
use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\HelperInterface;

class Block extends AbstractHelper
{
    /**
     * @var BlockTypeManagerInterface
     */
    private $typeManager;

    /**
     * @param BlockTypeManagerInterface $typeManager
     */
    public function __construct(BlockTypeManagerInterface $typeManager)
    {
        $this->typeManager = $typeManager;
    }

    /**
     * @param BlockInterface $block
     *
     * @return string
     */
    public function __invoke(BlockInterface $block)
    {
        $renderer = $this->getRendererFor($block);
        return $renderer($block);
    }

    /**
     * @param BlockInterface $block
     *
     * @return HelperInterface|callable
     */
    private function getRendererFor(BlockInterface $block)
    {
        $rendererKey = $this->typeManager->getRendererFor($block);
        return $this->getView()->plugin($rendererKey);
    }
} 