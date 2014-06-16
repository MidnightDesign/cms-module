<?php

namespace Midnight\CmsModule\Menu\View\Helper;

use Exception;
use Midnight\CmsModule\Menu\Item\ItemInterface;
use Midnight\CmsModule\Menu\MenuInterface;
use Midnight\CmsModule\Menu\Storage\StorageInterface;
use Zend\Http\PhpEnvironment\Request;
use Zend\Navigation\Navigation;
use Zend\Navigation\Page\AbstractPage;
use Zend\Navigation\Page\Uri;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\Navigation\Menu;

class CmsMenu extends AbstractHelper
{
    const DEFAULT_MENU = 'default';
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
     * @var Request
     */
    private $request;

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
     *
     * @return CmsMenu|string $this
     */
    public function __invoke($menuId = null)
    {
        if (null === $menuId) {
            return $this;
        }
        $navigation = $this->getNavigation($menuId);
        return $this->getNavigationHelper()->menu()->render($navigation);
    }

    /**
     * @param string $menuId
     *
     * @throws Exception
     * @return MenuInterface
     */
    private function getMenu($menuId)
    {
        if (self::DEFAULT_MENU === $menuId) {
            $menuId = $this->getDefaultMenuId();
        }
        $menu = $this->getStorage()->load($menuId);
        if(null === $menu) {
            throw new Exception(sprintf('Couldn\'t load menu "%s".', $menuId));
        }
        return $menu;
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
        $children = $item->getItems();
        if ($this->request->getRequestUri() === $item->getHref()) {
            $page->setActive();
        }
        if (!empty($children)) {
            foreach ($children as $child) {
                $page->addPage($this->getPage($child));
            }
        }
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
     * @param Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @param string $defaultMenuId
     */
    public function setDefaultMenuId($defaultMenuId)
    {
        $this->defaultMenuId = $defaultMenuId;
    }

    /**
     * @param $menuId
     *
     * @return Navigation
     */
    public function getNavigation($menuId = self::DEFAULT_MENU)
    {
        $menu = $this->getMenu($menuId);
        $navigation = new Navigation();
        foreach ($menu->getItems() as $item) {
            $navigation->addPage($this->getPage($item));

        }
        return $navigation;
    }
} 
