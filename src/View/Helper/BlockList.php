<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\Block\BlockInterface;
use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Zend\View\Helper\AbstractHelper;

class BlockList extends AbstractHelper
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
     * @param BlockInterface[] $blocks
     *
     * @return string
     */
    public function __invoke($blocks, $page)
    {
        $r = array();
        foreach ($blocks as $block) {
            if (!$this->blockTypeManager->getConfigFor($block)) {
                continue;
            }
            $blockHelper = $this->getView()->plugin('block');
            $r[] = $blockHelper($block, $page);
        }
        return join(PHP_EOL, $r);
    }
} 
