<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;
use ZfcRbac\Service\AuthorizationServiceInterface;

class BlockFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface|HelperPluginManager $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $typeManager = $this->getTypeManager($serviceLocator);
        $block = new Block($typeManager);
        $block->setAdminMode($this->getAuthorizationService($serviceLocator)->isGranted('cms.block.edit'));
        return $block;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return AuthorizationServiceInterface
     */
    private function getAuthorizationService(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->getServiceLocator()->get('ZfcRbac\Service\AuthorizationService');
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return BlockTypeManagerInterface
     */
    private function getTypeManager(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->getServiceLocator()->get('cms.block_type_manager');
    }
}
