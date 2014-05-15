<?php

namespace Midnight\CmsModule\Storage;

use Doctrine\Common\Persistence\ObjectManager;
use Midnight\Page\Storage\Doctrine;
use Midnight\Page\Storage\Filesystem;
use Midnight\Page\Storage\StorageInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PageStorageFactory implements FactoryInterface
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
        $storageConfig = $config['cms']['storage']['page'];
        switch ($storageConfig['type']) {
            case 'Midnight\Page\Storage\Doctrine':
                $storage = new Doctrine();
                /** @var $objectManager ObjectManager */
                $objectManager = $serviceLocator->get($storageConfig['options']['object_manager']);
                $storage->setObjectManager($objectManager);
                break;
            default:
                $blockStorage = new \Midnight\Block\Storage\Filesystem('data/cms/blocks');
                $storage = new Filesystem('data/cms/pages', $blockStorage);
                break;
        }
        return $storage;
    }
}
