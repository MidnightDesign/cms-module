<?php

namespace Midnight\CmsModule\Menu\Item;

use Midnight\CmsModule\Menu\AbstractItemContainer;

class Item extends AbstractItemContainer implements ItemInterface
{
    /**
     * @var string
     */
    private $label;
    /**
     * @var string
     */
    private $href;

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param string $href
     */
    public function setHref($href)
    {
        $this->href = $href;
    }
}
