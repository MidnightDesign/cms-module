<?php
/**
 * Created by PhpStorm.
 * User: rudi
 * Date: 08.05.14
 * Time: 10:28
 */

namespace Midnight\CmsModule\Controller\Block;

use Midnight\Block\Html;
use Midnight\CmsModule\Controller\AbstractCmsController;
use Midnight\Page\PageInterface;

class HtmlController extends AbstractCmsController implements BlockControllerInterface
{
    public function createAction()
    {
        $block = new Html();

        $pageId = $this->params()->fromQuery('page_id');
        if ($pageId) {
            $page = $this->getPageStorage()->load($pageId);
            $page->addBlock($block);
            $this->getPageStorage()->save($page);
            return $this->redirect()->toRoute('zfcadmin/cms/page/edit', array('page_id' => $page->getId()));
        } else {
            $this->getBlockStorage()->save($block);
            throw new \RuntimeException('Not implemented because I don\'t know where to redirect to.');
        }
    }

    public function editAction()
    {
        /** @var $page PageInterface */
        $page = $this->params()->fromRoute('page');
        if (!$page) {
            throw new \RuntimeException('Didn\'t get a page.');
        }
        return $this->redirect()->toRoute('cms_page', array('slug' => $page->getSlug()));
    }

    public function setHtmlAction()
    {
        $blockId = $this->params()->fromRoute('block_id');
        $storageInterface = $this->getBlockStorage();
        $block = $storageInterface->load($blockId);
        if (!$block instanceof Html) {
            throw new \RuntimeException(sprintf(
                'Block %s is not an instance of Midnight\Block\Html',
                $block->getId()
            ));
        }
        $this->checkPermission('cms.block.html.edit', $block);
        $block->setHtml($this->params()->fromPost('html'));
        $storageInterface->save($block);
        return $this->getResponse();
    }
}
