<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Midnight\Page\PageInterface;
use Zend\Form\View\Helper\AbstractHelper;

class Page extends AbstractHelper
{
    /**
     * @var BlockTypeManagerInterface
     */
    private $blockTypeManager;

    /**
     * @param PageInterface $page
     *
     * @return string
     */
    public function __invoke(PageInterface $page)
    {
        $headTitle = $this->getHeadTitleHelper();
        $headTitle($page->getName());

        $blockListHelper = $this->getBlockListHelper();
        return $blockListHelper($page->getBlocks(), $page);
    }

    /**
     * @param BlockTypeManagerInterface $blockTypeManager
     */
    public function setBlockTypeManager($blockTypeManager)
    {
        $this->blockTypeManager = $blockTypeManager;
    }

    private function getHeadTitleHelper()
    {
        return $this->getView()->plugin('headTitle');
    }

    /**
     * @return Block
     */
    private function getBlockHelper()
    {
        return $this->getView()->plugin('block');
    }

    /**
     * @return BlockList
     */
    private function getBlockListHelper()
    {
        return $this->getView()->plugin('blockList');
    }
}
