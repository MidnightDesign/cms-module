<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Midnight\Page\PageInterface;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\View\Helper\BasePath;
use Zend\View\Helper\HeadStyle;
use Zend\View\Helper\Url;
use ZfcRbac\Service\AuthorizationServiceInterface;

class Page extends AbstractHelper
{
    /**
     * @var BlockTypeManagerInterface
     */
    private $blockTypeManager;
    /**
     * @var AuthorizationServiceInterface
     */
    private $authorizationService;

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

        $r = array();
        $position = 0;

        $r[] = $this->getAddButton($page, $position++);

        foreach ($page->getBlocks() as $block) {
            if (!$this->blockTypeManager->getConfigFor($block)) {
                continue;
            }
            $blockHelper = $this->getBlockHelper();
            $r[] = $blockHelper($block, $page);
            $r[] = $this->getAddButton($page, $position++);
        }
        $content = join(PHP_EOL, $r);
        if ($this->authorizationService->isGranted('cms.page.edit')) {
            return sprintf('<div class="page-blocks">%s</div>', $content);
        } else {
            return $content;
        }
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
     * @param PageInterface $page
     * @param integer       $position
     *
     * @return string
     */
    private function getAddButton(PageInterface $page, $position)
    {
        if (!$this->authorizationService->isGranted('cms.page.add_block', $page)) {
            return '';
        }
        $urlHelper = $this->getUrlHelper();
        $href = $urlHelper(
            'zfcadmin/cms/block/create',
            array(),
            array('query' => array('page_id' => $page->getId(), 'position' => (string)$position))
        );
        return sprintf('<a href="%s" class="add-block-inline">Add block</a>', $href);
    }

    /**
     * @return Url
     */
    private function getUrlHelper()
    {
        return $this->getView()->plugin('url');
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

    /**
     * @param AuthorizationServiceInterface $authorizationService
     */
    public function setAuthorizationService(AuthorizationServiceInterface $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }
}
