<?php

namespace Midnight\CmsModule\InlineBlockOption;

use Midnight\Block\BlockInterface;
use Midnight\Page\PageInterface;

/**
 * Interface InlineOptionsProviderInterface
 * @package Midnight\CmsModule\Service
 *
 * Provides buttons on frontend editing
 */
interface InlineOptionsProviderInterface
{
    /**
     * @param BlockInterface $block
     * @param PageInterface  $page
     *
     * @return OptionInterface[]
     */
    public function getOptions(BlockInterface $block, PageInterface $page);
}
