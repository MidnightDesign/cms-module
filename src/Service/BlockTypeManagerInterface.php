<?php

namespace Midnight\CmsModule\Service;

use Midnight\Block\BlockInterface;

interface BlockTypeManagerInterface
{
    /**
     * @param BlockInterface $block
     *
     * @return string
     */
    public function getRendererFor(BlockInterface $block);
}