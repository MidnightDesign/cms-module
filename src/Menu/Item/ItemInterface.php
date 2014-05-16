<?php

namespace Midnight\CmsModule\Menu\Item;

use Midnight\CmsModule\Menu\ItemContainerInterface;

interface ItemInterface extends ItemContainerInterface
{
    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return string
     */
    public function getHref();
}
