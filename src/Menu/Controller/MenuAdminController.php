<?php

namespace Midnight\CmsModule\Menu\Controller;

use Midnight\CmsModule\Menu\Item\Type\ItemTypeManagerInterface;
use Midnight\CmsModule\Menu\Menu;
use Zend\View\Model\ViewModel;

class MenuAdminController extends AbstractMenuController
{
    public function indexAction()
    {
        $menu = $this->getDefaultMenu();
        return $this->redirect()->toRoute('zfcadmin/cms/menu/edit', array('menu_id' => $menu->getId()));
    }

    public function editAction()
    {
        $menuId = $this->params()->fromRoute('menu_id');
        $menu = $this->getMenuStorage()->load($menuId);

        $vm = new ViewModel(array('menu' => $menu));
        $vm->setTemplate('midnight/cms-module/menu/menu-admin/edit.phtml');
        return $vm;
    }

    public function createItemAction()
    {
        $typeManager = $this->getItemTypeManager();
        $menuId = $this->params()->fromRoute('menu_id');
        $menu = $this->getMenuStorage()->load($menuId);

        $types = $typeManager->getTypes();

        $itemTypeKey = $this->params()->fromRoute('item_type');
        if (empty($itemTypeKey) && sizeof($types) === 1) {
            $type = current($types);
            $itemTypeKey = $type->getKey();
        }
        if ($itemTypeKey) {
            $itemType = $typeManager->get($itemTypeKey);
            return $this->forward()->dispatch(
                $itemType->getControllerName(),
                array('action' => 'create', 'menu' => $menu)
            );
        }

        $vm = new ViewModel(array('menu' => $menu, 'types' => $types));
        $vm->setTemplate('midnight/cms-module/menu/menu-admin/create-item.phtml');
        return $vm;
    }

    public function deleteItemAction()
    {
        $menuId = $this->params()->fromRoute('menu_id');
        $path = $this->params()->fromRoute('path');
        $menuStorage = $this->getMenuStorage();
        $menu = $menuStorage->load($menuId);
        $menu->deleteItemByPath(explode('/', $path));
        $menuStorage->save($menu);
        return $this->redirect()->toRoute('zfcadmin/cms/menu/edit', array('menu_id' => $menu->getId()));
    }

    private function getDefaultMenu()
    {
        $defaultMenuId = $this->getDefaultMenuId();
        $menu = $this->getMenuStorage()->load($defaultMenuId);
        if (!$menu) {
            $menu = new Menu();
            $menu->setId($defaultMenuId);
            $this->getMenuStorage()->save($menu);
        }
        return $menu;
    }

    private function getDefaultMenuId()
    {
        return 'default';
    }

    /**
     * @return ItemTypeManagerInterface
     */
    private function getItemTypeManager()
    {
        return $this->getServiceLocator()->get('cms.menu.item_type_manager');
    }
} 
