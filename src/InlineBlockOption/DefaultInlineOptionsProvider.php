<?php

namespace Midnight\CmsModule\InlineBlockOption;

use Midnight\Block\BlockInterface;
use Midnight\Page\PageInterface;
use Zend\Mvc\Router\RouteStackInterface;

class DefaultInlineOptionsProvider implements InlineOptionsProviderInterface
{
    /**
     * @var RouteStackInterface
     */
    protected $router;

    /**
     * @param BlockInterface $block
     * @param PageInterface  $page
     *
     * @return OptionInterface[]
     */
    public function getOptions(BlockInterface $block, PageInterface $page)
    {
        $options = array();

        $up = $this->getUp($block, $page);
        if ($up) {
            $options[] = $up;
        }

        $options[] = $this->getDelete($block, $page);

        return $options;
    }

    /**
     * @param RouteStackInterface $router
     */
    public function setRouter(RouteStackInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param BlockInterface $block
     * @param PageInterface  $page
     *
     * @return Option|null
     */
    protected function getUp(BlockInterface $block, PageInterface $page)
    {
        $up = new Option();
        $up->setLabel('Up');
        $prevBlock = null;
        foreach ($page->getBlocks() as $b) {
            if ($b === $block) {
                break;
            }
            $prevBlock = $b;
        }
        if (null === $prevBlock) {
            return null;
        }
        $up->setHref($this->router->assemble(
            array('page_id' => $page->getId(), 'block_id' => $block->getId()),
            array('name' => 'zfcadmin/cms/page/move_block', 'query' => array('before' => $prevBlock->getId()))
        ));
        $up->addClass('up');
        return $up;
    }

    /**
     * @param BlockInterface $block
     * @param PageInterface  $page
     *
     * @return OptionInterface
     */
    private function getDelete(BlockInterface $block, PageInterface $page)
    {
        $option = new Option();
        $option->setLabel('Delete');
        $href = $this->router->assemble(
            array('page_id' => $page->getId(), 'block_id' => $block->getId()),
            array('name' => 'zfcadmin/cms/page/delete_block')
        );
        $option->setHref($href);
        $option->addClass('delete confirm');
        return $option;
    }
}
