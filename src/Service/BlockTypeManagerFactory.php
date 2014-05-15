<?php

namespace Midnight\CmsModule\Service;

use Midnight\CmsModule\InlineBlockOption\DefaultInlineOptionsProvider;
use Zend\Mvc\Router\RouteStackInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BlockTypeManagerFactory implements FactoryInterface
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
        $config = $serviceLocator->get('Config');
        $blockConfig = $config['cms']['blocks'];
        $blockTypeManager = new BlockTypeManager($blockConfig);
        $defaultInlineOptionsProvider = new DefaultInlineOptionsProvider();
        $defaultInlineOptionsProvider->setRouter($this->getRouter($serviceLocator));
        $blockTypeManager->setDefaultInlineOptionsProvider($defaultInlineOptionsProvider);
        return $blockTypeManager;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return RouteStackInterface
     */
    private function getRouter(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->get('Router');
    }
}
