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
        $page = $this->getPageStorage()->loadBySlug($this->params()->fromRoute('slug'));
        $blockTypes = $this->getBlockTypes();

        $vm = new ViewModel(array('page' => $page, 'blockTypes' => $blockTypes));
        $vm->setTemplate('midnight/cms-module/page/view.phtml');
        return $vm;
    }
}
