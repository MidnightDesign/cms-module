<?php

namespace Midnight\CmsModule\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

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
        $htmlBlock->setEditable(true);
        return $htmlBlock;
    }
}