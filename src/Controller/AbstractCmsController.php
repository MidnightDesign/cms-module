<?php

namespace Midnight\CmsModule\Controller;

use Midnight\Block\Storage\StorageInterface as BlockStorageInterface;
use Midnight\Page\Storage\StorageInterface as PageStorageInterface;
use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractCmsController extends AbstractActionController
{
    /**
     * @return PageStorageInterface
     */
    protected function getPageStorage()
    {
        return $this->getServiceLocator()->get('cms.page_storage');
    }

    /**
     * @return BlockStorageInterface
     */
    protected function getBlockStorage()
    {
        return $this->getServiceLocator()->get('cms.block_storage');
    }

    /**
     * @return array
     */
    protected function getBlockTypes()
    {
        $config = $this->getServiceLocator()->get('Config');
        return $config['cms']['blocks'];
    }
}
