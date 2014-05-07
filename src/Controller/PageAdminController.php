<?php

namespace Midnight\CmsModule\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Midnight\CmsModule\Form\PageForm;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class PageAdminController
 * @package Midnight\CmsModule\Controller
 */
class PageAdminController extends AbstractActionController
{
    public function indexAction()
    {
        $vm = new ViewModel();
        $vm->setTemplate('midnight/cms-module/page-admin/index.phtml');
        return $vm;
    }

    public function createAction()
    {
        $form = new PageForm();

        $request = $this->getRequest();
        if($request instanceof Request && $request->isPost()) {
            $form->setData($request->getPost());
            if($form->isValid()) {
                $page = $form->getObject();
                $objectManager = $this->getObjectManager();
                $objectManager->persist($page);
                $objectManager->flush();
            }
        }

        $vm = new ViewModel(array('form' => $form));
        $vm->setTemplate('midnight/cms-module/page-admin/create.phtml');
        return $vm;
    }

    /**
     * @return ObjectManager
     */
    private function getObjectManager()
    {
        return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    }
}