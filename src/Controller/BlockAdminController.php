<?php

namespace Midnight\CmsModule\Controller;

use Midnight\CmsModule\Controller\Block\BlockControllerInterface;
use Zend\View\Model\ViewModel;

/**
 * Class BlockAdminController
 * @package Midnight\CmsModule\Controller
 */
class BlockAdminController extends AbstractCmsController
{
    public function createAction()
    {
        // Load block types
        $blockTypes = $this->getBlockTypes();

        // Load page if we received an ID
        $pageId = $this->params()->fromQuery('page_id');
        $page = $pageId ? $this->getPageStorage()->load($pageId) : null;

        // Redirect if a block type was set
        $typeKey = $this->params()->fromRoute('block_type');
        if ($typeKey) {
            if (empty($blockTypes[$typeKey]['controller'])) {
                throw new \RuntimeException(sprintf(
                    'The configuration for the block type \'%s\' is missing the key \'controller\'.',
                    $typeKey
                ));
            }
            $controllerKey = $blockTypes[$typeKey]['controller'];
            $controller = $this->getServiceLocator()->get('ControllerManager')->get($controllerKey);
            if (!$controller instanceof BlockControllerInterface) {
                throw new \Exception(sprintf(
                    '%s must implement Midnight\CmsModule\Controller\Block\BlockControllerInterface.',
                    get_class($controller)
                ));
            }
            return $this->forward()->dispatch(
                $controllerKey,
                array('action' => 'create', 'page_id' => $page->getId())
            );
        }

        // View model
        $vm = new ViewModel(array('blockTypes' => $blockTypes, 'page' => $page));
        $vm->setTemplate('midnight/cms-module/block-admin/create.phtml');
        return $vm;
    }

    public function editAction()
    {
        $blockId = $this->params()->fromRoute('block_id');

        // Extract the block from the page if we got a page ID, otherwise load it independently.
        $pageId = $this->params()->fromQuery('page_id');
        if ($pageId) {
            $page = $this->getPageStorage()->load($pageId);
            foreach ($page->getBlocks() as $block) {
                if ($block->getId() === $blockId) {
                    break;
                }
            }
        } else {
            $page = null;
            $block = $this->getBlockStorage()->load($blockId);
        }

        if (empty($block)) {
            throw new \RuntimeException('Couldn\'t find block %s', $blockId);
        }

        // Get block type
        $blockTypes = $this->getBlockTypes();
        foreach ($blockTypes as $type) {
            if ($block instanceof $type['class']) {
                break;
            }
        }

        if (!isset($type)) {
            throw new \RuntimeException(sprintf(
                'Couldn\'t find a block type with the class %s.',
                get_class($block)
            ));
        }

        return $this->forward()->dispatch(
            $type['controller'],
            array('action' => 'edit', 'block' => $block, 'page' => $page)
        );
    }
}