<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\Block\Html;
use Midnight\Wysiwyg\View\Helper\Wysiwyg;
use Zend\Form\View\Helper\AbstractHelper;

class HtmlBlock extends AbstractHelper
{
    /**
     * @var boolean
     */
    private $editable = false;

    /**
     * @param Html $block
     *
     * @return string
     */
    public function __invoke(Html $block)
    {
        if ($this->editable) {
            return $this->renderEditable($block);
        }
        return $block->getHtml();
    }

    /**
     * @param boolean $editable
     */
    public function setEditable($editable)
    {
        $this->editable = $editable;
    }

    private function renderEditable(Html $block)
    {
        /** @var $wysiwyg Wysiwyg */
        $wysiwyg = $this->getView()->plugin('wysiwyg');
        $urlPlugin = $this->getView()->plugin('url');
        $saveUrl = $urlPlugin('zfcadmin/cms/block/set_html', array('block_id' => $block->getId()));
        return $wysiwyg($block->getHtml(), array('data-save-url' => $saveUrl));
    }
} 