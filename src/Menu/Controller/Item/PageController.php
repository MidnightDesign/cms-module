<?php

namespace Midnight\CmsModule\Menu\Controller\Item;

use Midnight\CmsModule\Menu\Controller\AbstractMenuController;
use Midnight\CmsModule\Menu\Item\Item;
use Midnight\CmsModule\Menu\Item\Page\Page;
use Midnight\CmsModule\Menu\Item\Page\PageItemForm;
use Midnight\CmsModule\Menu\MenuInterface;
use Zend\Http\Request;
use Zend\View\Model\ViewModel;

/**
 * Class PageController
 * @package Midnight\CmsModule\Menu\Controller\Item
 *
 * @method Request getRequest()
 */
class PageController extends AbstractMenuController implements ItemControllerInterface
{
    public function createAction()
    {
        /** @var $menu MenuInterface */
        $menu = $this->params()->fromRoute('menu');
        $form = new PageItemForm($this->getPageStorage(), $menu);

        $path = $this->params()->fromQuery('path');
        if ($path) {
            $form->get('path')->setValue($path);
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);
            if ($form->isValid()) {
                $item = new Item();
                $page = $this->getPageStorage()->load($data['page_id']);
                $item->setLabel($page->getName());
                $item->setHref($this->url()->fromRoute('cms_page', array('page_id' => $page->getId())));
                if (!empty($data['path'])) {
                    $path = explode('-', $data['path']);
                } else {
                    $path = array(count($menu->getItems()));
                }
                $menu->addItem($item, $path);
                $this->getMenuStorage()->save($menu);
                return $this->redirect()->toRoute('zfcadmin/cms/menu/edit', array('menu_id' => $menu->getId()));
            }
        }

        $vm = new ViewModel(array('form' => $form));
        $vm->setTemplate('midnight/cms-module/menu/item/page/create.phtml');
        return $vm;
    }
}
