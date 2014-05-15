<?php

namespace Midnight\CmsModule\Service;

use Midnight\Block\BlockInterface;
use Midnight\CmsModule\InlineBlockOption\InlineOptionsProviderInterface;

interface BlockTypeManagerInterface
{
    /**
     * @param BlockInterface $block
     *
     * @return string
     */
    public function getRendererFor(BlockInterface $block);

    /**
     * @param BlockInterface $block
     *
     * @return string
     */
    public function getPreviewRendererFor(BlockInterface $block);

    /**
     * @param BlockInterface $block
     *
     * @return InlineOptionsProviderInterface
     */
    public function getInlineOptionsProviderFor($block);

    /**
     * @param BlockInterface $block
     *
     * @return array
     */
    public function getConfigFor(BlockInterface $block);

    /**
     * @param BlockInterface $block
     *
     * @return string
     */
    public function getInlineContainerClassFor(BlockInterface $block);
}
