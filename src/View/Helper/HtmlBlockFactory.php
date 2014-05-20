<?php

namespace Midnight\CmsModule\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcRbac\Service\AuthorizationServiceInterface;

class HtmlBlockFactory implements FactoryInterface
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
        $htmlBlock = new HtmlBlock();
        $authService = $this->getAuthorizationService($serviceLocator);
        if ($authService->isGranted('cms.block.html.edit', $htmlBlock)) {
            $htmlBlock->setEditable(true);
        }
        return $htmlBlock;
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
