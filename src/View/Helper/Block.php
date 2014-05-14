<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\Block\BlockInterface;
use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Midnight\Page\PageInterface;
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
     * @param PageInterface  $page
     *
     * @return string
     */
    public function __invoke(BlockInterface $block, PageInterface $page)
    {
        $view = $this->getView();
        $headLink = $view->plugin('headLink');
        $headScript = $view->plugin('headScript');
        $basePath = $view->plugin('basePath');
        $headLink
            ->appendStylesheet($basePath('css/midnight/cms-module/admin/page.css'))
            ->appendStylesheet($basePath('css/midnight/admin-module/ui.css'));
        $headScript
            ->appendFile($basePath('js/midnight/cms-module/page.js'))
            ->appendFile($basePath('js/admin-module/ui.js'));

        $prevBlock = null;
        foreach ($page->getBlocks() as $b) {
            if ($b === $block) {
                break;
            }
            $prevBlock = $b;
        }

        $options = $this->getView()->partial('midnight/cms-module/page-admin/edit/block-options.phtml', array(
            'block' => $block,
            'page' => $page,
            'prevBlock' => $prevBlock,
        ));

        $renderer = $this->getRendererFor($block);
        return '<div class="midnight-cms-block">' . $options . $renderer($block) . '</div>';
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
