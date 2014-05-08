<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\Block\Html;
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
        return sprintf('<div contenteditable="true">%s</div>', $block->getHtml());
    }
} 