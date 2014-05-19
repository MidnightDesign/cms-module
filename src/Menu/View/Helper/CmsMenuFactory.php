<?php

namespace Midnight\CmsModule\Menu\View\Helper;

use Midnight\CmsModule\Menu\Storage\StorageInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class CmsMenuFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $helper = new CmsMenu();

        /** @var $sl ServiceManager */
        $sl = $serviceLocator->getServiceLocator();
        $config = $sl->get('Config');
        $helper->setDefaultMenuId($config['cms']['menu']['default_menu_id']);

        /** @var $storage StorageInterface */
        $storage = $sl->get('cms.menu.storage');
        $helper->setStorage($storage);

        $helper->setNavigationHelper($serviceLocator->get('navigation'));

        return $helper;
    }
}
