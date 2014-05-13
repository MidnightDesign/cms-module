<?php

namespace Midnight\CmsModule\Controller;

use Midnight\CmsModule\Form\PageForm;
use Midnight\Page\Page;
use Midnight\Page\PageInterface;
use Zend\Http\PhpEnvironment\Request;
use Zend\View\Model\ViewModel;

/**
 * Class PageAdminController
 * @package Midnight\CmsModule\Controller
 */
class PageAdminController extends AbstractCmsController
{
    public function indexAction()
    {
        $pages = $this->getPageStorage()->getAll();
        $vm = new ViewModel(array('pages' => $pages));
        $vm->setTemplate('midnight/cms-module/page-admin/index.phtml');
        return $vm;
    }

    public function createAction()
    {
        $form = new PageForm();
        $form->bind(new Page());

        $request = $this->getRequest();
        if ($request instanceof Request && $request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                /** @var $page PageInterface */
                $page = $form->getObject();
                $this->getPageStorage()->save($page);
                return $this->redirect()->toRoute('zfcadmin/cms/page/edit', array('page_id' => $page->getId()));
            }
        }

        $vm = new ViewModel(array('form' => $form));
        $vm->setTemplate('midnight/cms-module/page-admin/create.phtml');
        return $vm;
    }

    public function editAction()
    {
        $page = $this->getPageStorage()->load($this->params()->fromRoute('page_id'));
        $blockTypes = $this->getBlockTypes();

        $vm = new ViewModel(array('page' => $page, 'blockTypes' => $blockTypes));
        $vm->setTemplate('midnight/cms-module/page-admin/edit.phtml');
        return $vm;
    }

    public function deleteBlockAction()
    {
        $pageStorage = $this->getPageStorage();
        $page = $pageStorage->load($this->params()->fromRoute('page_id'));
        $block = $page->getBlock($this->params()->fromRoute('block_id'));
        $page->removeBlock($block);
        $this->getBlockStorage()->delete($block);
        $pageStorage->save($page);
        $this->flashMessenger()->addSuccessMessage('The block was successfully deleted.');
        return $this->redirect()->toRoute('zfcadmin/cms/page/edit', array('page_id' => $page->getId()));
    }

    public function moveBlockAction()
    {
        $pageStorage = $this->getPageStorage();
        $page = $pageStorage->load($this->params()->fromRoute('page_id'));
        $block = $page->getBlock($this->params()->fromRoute('block_id'));

        $before = $this->params()->fromQuery('before');
        $after = $this->params()->fromQuery('after');
        if ($before) {
            $otherBlockId = $before;
            $position = PageInterface::BEFORE;
        } elseif ($after) {
            $otherBlockId = $after;
            $position = PageInterface::AFTER;
        } else {
            throw new \InvalidArgumentException('Expected "before" or "after" in the query string.');
        }
        $otherBlock = $page->getBlock($otherBlockId);
        $page->moveBlock($block, $otherBlock, $position);
        $pageStorage->save($page);
        return $this->redirect()->toRoute('zfcadmin/cms/page/edit', array('page_id' => $page->getId()));
    }
}
