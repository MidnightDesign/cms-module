<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BlockListFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return BlockList
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new BlockList($this->getBlockTypeManager($serviceLocator));
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
}
