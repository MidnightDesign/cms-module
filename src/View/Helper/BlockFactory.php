<?php

namespace Midnight\CmsModule\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;

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
        $typeManager = $serviceLocator->getServiceLocator()->get('cms.block_type_manager');
        return new Block($typeManager);
    }
}