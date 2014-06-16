<?php

namespace Midnight\CmsModule\Controller;

use Midnight\Block\Html;
use Zend\View\Model\ViewModel;

/**
 * Class PageController
 * @package Midnight\CmsModule\Controller
 */
class PageController extends AbstractCmsController
{
    public function viewAction()
    {
        $pageStorage = $this->getPageStorage();
        $page = $pageStorage->loadBySlug($this->params()->fromRoute('slug'));
        if (count($page->getBlocks()) === 0) {
            $page->addBlock(new Html());
            $pageStorage->save($page);
        }
        $blockTypes = $this->getBlockTypes();

        $vm = new ViewModel(array('page' => $page, 'blockTypes' => $blockTypes));
        $vm->setTemplate('midnight/cms-module/page/view.phtml');
        return $vm;
    }
}
