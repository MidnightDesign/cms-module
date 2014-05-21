<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcRbac\Service\AuthorizationServiceInterface;

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
        $page->setAuthorizationService($this->getAuthorizationService());
        return $page;
    }

    /**
     * @return BlockTypeManagerInterface
     */
    private function getBlockTypeManager()
    {
        return $this->sl->getServiceLocator()->get('cms.block_type_manager');
    }

    /**
     * @return AuthorizationServiceInterface
     */
    private function getAuthorizationService()
    {
        return $this->sl->getServiceLocator()->get('ZfcRbac\Service\AuthorizationService');
    }
}
