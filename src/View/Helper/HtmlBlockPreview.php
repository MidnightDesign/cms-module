<?php

namespace Midnight\CmsModule\View\Helper;

use Midnight\Block\Html;
use Zend\View\Helper\AbstractHelper;

class HtmlBlockPreview extends AbstractHelper
{
    public function __invoke(Html $block)
    {
        $content = strip_tags($block->getHtml());
        if (!trim($content)) {
            return '<i>Empty</i>';
        }
        return substr($content, 0, 512);
    }
} 
