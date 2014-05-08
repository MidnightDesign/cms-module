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
        return $this->redirect()->toRoute('cms_page', array('page_id' => $page->getId()));
    }
}