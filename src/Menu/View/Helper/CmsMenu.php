<?php

namespace Midnight\CmsModule\Menu\View\Helper;

use Midnight\CmsModule\Menu\Item\ItemInterface;
use Midnight\CmsModule\Menu\MenuInterface;
use Midnight\CmsModule\Menu\Storage\StorageInterface;
use Zend\Navigation\Navigation;
use Zend\Navigation\Page\AbstractPage;
use Zend\Navigation\Page\Uri;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\Navigation\Menu;

class CmsMenu extends AbstractHelper
{
    /**
     * @var string
     */
    private $defaultMenuId;
    /**
     * @var StorageInterface
     */
    private $storage;
    /**
     * @var \Zend\View\Helper\Navigation
     */
    private $navigationHelper;

    /**
     * @param Menu $menuPlugin
     */
    public function setNavigationHelper($menuPlugin)
    {
        $this->navigationHelper = $menuPlugin;
    }

    /**
     * @param StorageInterface $storage
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param string|null $menuId
     */
    public function __invoke($menuId = null)
    {
        $menu = $this->getMenu($menuId);
        $navigation = new Navigation();
        foreach ($menu->getItems() as $item) {
            $navigation->addPage($this->getPage($item));
        }
        return $this->getNavigationHelper()->menu()->render($navigation);
    }

    /**
     * @param string $menuId
     *
     * @return MenuInterface
     */
    private function getMenu($menuId)
    {
        if (null === $menuId) {
            $menuId = $this->getDefaultMenuId();
        }
        return $this->getStorage()->load($menuId);
    }

    /**
     * @return string
     */
    private function getDefaultMenuId()
    {
        $defaultMenuId = $this->defaultMenuId;
        if (empty($defaultMenuId)) {
            throw new \RuntimeException('There is no default menu ID set.');
        }
        return $defaultMenuId;
    }

    /**
     * @return StorageInterface
     */
    private function getStorage()
    {
        return $this->storage;
    }

    /**
     * @param ItemInterface $item
     *
     * @return AbstractPage
     */
    private function getPage(ItemInterface $item)
    {
        $page = new Uri();
        $page->setLabel($item->getLabel());
        $page->setUri($item->getHref());
        return $page;
    }

    /**
     * @return \Zend\View\Helper\Navigation
     */
    private function getNavigationHelper()
    {
        return $this->navigationHelper;
    }

    /**
     * @param string $defaultMenuId
     */
    public function setDefaultMenuId($defaultMenuId)
    {
        $this->defaultMenuId = $defaultMenuId;
    }
} 
