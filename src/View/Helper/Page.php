<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Midnight\Page\PageInterface;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\View\Helper\BasePath;
use Zend\View\Helper\HeadStyle;

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
        $headLink = $this->getHeadLinkHelper();
        $basePath = $this->getBasePathHelper();
        $headLink->appendStylesheet($basePath('css/midnight/cms-module/admin/page.css'));

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
     * @return BlockList
     */
    private function getBlockListHelper()
    {
        return $this->getView()->plugin('blockList');
    }

    /**
     * @return HeadStyle
     */
    private function getHeadLinkHelper()
    {
        return $this->getView()->plugin('headLink');
    }

    /**
     * @return BasePath
     */
    private function getBasePathHelper()
    {
        return $this->getView()->plugin('basePath');
    }
}
