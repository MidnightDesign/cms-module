<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\CmsModule\Service\BlockTypeManagerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BlockPreviewFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return BlockPreview
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $blockTypeManager BlockTypeManagerInterface */
        $blockTypeManager = $serviceLocator->getServiceLocator()->get('cms.block_type_manager');
        return new BlockPreview($blockTypeManager);
    }
}
