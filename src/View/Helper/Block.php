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
     * @var boolean
     */
    private $adminMode;

    /**
     * @param BlockTypeManagerInterface $typeManager
     */
    public function __construct(BlockTypeManagerInterface $typeManager)
    {
        $this->typeManager = $typeManager;
    }

    /**
     * @return boolean
     */
    public function isAdminMode()
    {
        return $this->adminMode;
    }

    /**
     * @param boolean $adminMode
     */
    public function setAdminMode($adminMode)
    {
        $this->adminMode = $adminMode;
    }

    /**
     * @param BlockInterface $block
     * @param PageInterface  $page
     *
     * @return string
     */
    public function __invoke(BlockInterface $block, PageInterface $page)
    {
        $renderer = $this->getRendererFor($block);
        $content = $renderer($block, $page);

        if ($this->isAdminMode()) {
            $view = $this->getView();
            $headLink = $view->plugin('headLink');
            $inlineScript = $view->plugin('inlineScript');
            $basePath = $view->plugin('basePath');
            $headLink
                ->appendStylesheet($basePath('css/midnight/admin-module/ui.css'));
            $inlineScript
                ->appendFile($basePath('js/midnight/cms-module/page.js'))
                ->appendFile($basePath('js/midnight/admin-module/ui.js'));
            /** @var $partial Partial */
            $partial = $this->getView()->plugin('partial');
            $options = $partial(
                'midnight/cms-module/page-admin/edit/block-options.phtml',
                array('options' => $this->getInlineOptionsFor($block, $page))
            );
            $containerClass = $this->typeManager->getInlineContainerClassFor($block);
            return '<div class="midnight-cms-block ' . $containerClass . '">' . $options . $content . '</div>';
        } else {
            return $content;
        }
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
