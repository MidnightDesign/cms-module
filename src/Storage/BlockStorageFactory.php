<?php

namespace Midnight\CmsModule\Storage;

use Doctrine\Common\Persistence\ObjectManager;
use Midnight\Block\Storage\Doctrine;
use Midnight\Block\Storage\Filesystem;
use Midnight\Page\Storage\StorageInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BlockStorageFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return StorageInterface
     * @todo switch() isn't very extensible. Maybe delegate to another service factory?
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $storageConfig = $config['cms']['storage']['block'];
        switch ($storageConfig['type']) {
            case 'Midnight\Block\Storage\Doctrine':
                $storage = new Doctrine();
                /** @var $objectManager ObjectManager */
                $objectManager = $serviceLocator->get($storageConfig['options']['object_manager']);
                $storage->setObjectManager($objectManager);
                break;
            case 'Midnight\Block\Storage\Filesystem':
            default:
                $storage = new Filesystem($storageConfig['options']['directory']);
                break;
        }
        return $storage;
    }
}
