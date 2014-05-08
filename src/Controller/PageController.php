<?php

namespace Midnight\CmsModule\Controller;

use Zend\View\Model\ViewModel;

/**
 * Class PageController
 * @package Midnight\CmsModule\Controller
 */
class PageController extends AbstractCmsController
{
    public function viewAction()
    {
        $page = $this->getPageStorage()->load($this->params()->fromRoute('page_id'));
        $blockTypes = $this->getBlockTypes();

        $vm = new ViewModel(array('page' => $page, 'blockTypes' => $blockTypes));
        $vm->setTemplate('midnight/cms-module/page/view.phtml');
        return $vm;
    }
}