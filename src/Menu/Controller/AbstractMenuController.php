<?php

namespace Midnight\CmsModule\Menu\Controller;

use Midnight\CmsModule\Controller\AbstractCmsController;
use Midnight\CmsModule\Menu\Storage\StorageInterface;

abstract class AbstractMenuController extends AbstractCmsController
{
    /**
     * @return StorageInterface
     */
    protected function getMenuStorage()
    {
        return $this->getServiceLocator()->get('cms.menu.storage');
    }
}
