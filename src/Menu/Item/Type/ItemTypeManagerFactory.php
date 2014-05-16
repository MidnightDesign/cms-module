<?php

namespace Midnight\CmsModule\Menu\Item\Type;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ItemTypeManagerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ItemTypeManagerInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $typeConfig = $config['cms']['menu']['item_types'];
        return new ItemTypeManager($typeConfig);
    }
}
