<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\Block\BlockInterface;
use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Midnight\Page\PageInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\Url;
use ZfcRbac\Service\AuthorizationServiceInterface;

class BlockList extends AbstractHelper
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
     * @param BlockTypeManagerInterface     $blockTypeManager
     * @param AuthorizationServiceInterface $authorizationService
     */
    public function __construct(
        BlockTypeManagerInterface $blockTypeManager,
        AuthorizationServiceInterface $authorizationService
    )
    {
        $this->blockTypeManager = $blockTypeManager;
        $this->authorizationService = $authorizationService;
    }

    /**
     * @param BlockInterface[] $blocks
     * @param PageInterface    $page
     *
     * @return string
     */
    public function __invoke($blocks, PageInterface $page)
    {
        $r = array();
        $position = 0;

        $r[] = $this->getAddButton($page, $position++);

        foreach ($blocks as $block) {
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
     * @return Block
     */
    private function getBlockHelper()
    {
        return $this->getView()->plugin('block');
    }
} 
