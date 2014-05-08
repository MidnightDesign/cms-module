<?php

namespace Midnight\CmsModule\Controller;

use Midnight\Block\Storage\Filesystem as BlockStorage;
use Midnight\Block\Storage\StorageInterface as BlockStorageInterface;
use Midnight\Page\Storage\Filesystem as PageStorage;
use Midnight\Page\Storage\StorageInterface as PageStorageInterface;
use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractCmsController extends AbstractActionController
{
    /**
     * @return PageStorageInterface
     */
    protected function getPageStorage()
    {
        $directory = 'data/pages';
        if (!is_dir($directory)) {
            mkdir($directory, null, true);
        }
        $directory = realpath($directory);
        return new PageStorage($directory, $this->getBlockStorage());
    }

    /**
     * @return BlockStorageInterface
     */
    protected function getBlockStorage()
    {
        $directory = 'data/blocks';
        if (!is_dir($directory)) {
            mkdir($directory, null, true);
        }
        $directory = realpath($directory);
        return new BlockStorage($directory);
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