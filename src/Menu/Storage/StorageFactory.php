<?php

namespace Midnight\CmsModule\Menu\Storage;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class StorageFactory implements FactoryInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return StorageInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $config = $this->getConfig();
        $storageConfig = $config['cms']['menu']['storage'];
        $options = $storageConfig['options'];
        $storageType = $storageConfig['type'];
        return new $storageType($options);
    }

    /**
     * @return array
     */
    private function getConfig()
    {
        return $this->serviceLocator->get('Config');
    }
}
