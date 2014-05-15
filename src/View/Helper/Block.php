<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\Block\BlockInterface;
use Midnight\CmsModule\InlineBlockOption\OptionInterface;
use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Midnight\Page\PageInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\HelperInterface;
use Zend\View\Helper\Partial;

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

        /** @var $partial Partial */
        $partial = $this->getView()->plugin('partial');
        $options = $partial(
            'midnight/cms-module/page-admin/edit/block-options.phtml',
            array('options' => $this->getInlineOptionsFor($block, $page))
        );

        $renderer = $this->getRendererFor($block);

        $containerClass = $this->typeManager->getInlineContainerClassFor($block);
        return '<div class="midnight-cms-block ' . $containerClass . '">' . $options . $renderer($block) . '</div>';
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

    /**
     * @param BlockInterface $block
     * @param PageInterface  $page
     *
     * @return OptionInterface[]
     */
    private function getInlineOptionsFor(BlockInterface $block, PageInterface $page)
    {
        return $this->typeManager->getInlineOptionsProviderFor($block)->getOptions($block, $page);
    }
} 
