<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcRbac\Service\AuthorizationServiceInterface;

class BlockListFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return BlockList
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $blockTypeManager = $this->getBlockTypeManager($serviceLocator);
        $authorizationService = $this->getAuthorizationService($serviceLocator);
        return new BlockList($blockTypeManager, $authorizationService);
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return BlockTypeManagerInterface
     */
    private function getBlockTypeManager(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->getServiceLocator()->get('cms.block_type_manager');
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
}
