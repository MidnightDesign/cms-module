<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PageFactory implements FactoryInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    private $sl;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->sl = $serviceLocator;
        $page = new Page();
        $page->setBlockTypeManager($this->getBlockTypeManager());
        return $page;
    }

    /**
     * @return BlockTypeManagerInterface
     */
    private function getBlockTypeManager()
    {
       return  $this->sl->getServiceLocator()->get('cms.block_type_manager');
    }
}
