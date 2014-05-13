<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\Block\BlockInterface;
use Midnight\CmsModule\Exception\MissingConfigException;
use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Zend\View\Helper\AbstractHelper;

class BlockPreview extends AbstractHelper
{
    /**
     * @var BlockTypeManagerInterface
     */
    private $blockTypeManager;

    /**
     * @param BlockTypeManagerInterface $blockTypeManager
     */
    public function __construct(BlockTypeManagerInterface $blockTypeManager)
    {
        $this->blockTypeManager = $blockTypeManager;
    }

    /**
     * @param BlockInterface $block
     *
     * @return string
     */
    public function __invoke(BlockInterface $block)
    {
        try {
            $plugin = $this->blockTypeManager->getPreviewRendererFor($block);
            $renderer = $this->getView()->plugin($plugin);
            return $renderer($block);
        } catch (MissingConfigException $e) {
            return get_class($block);
        }
    }
} 
