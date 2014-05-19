<?php

namespace Midnight\CmsModule\Menu;

use Midnight\CmsModule\Menu\Item\ItemInterface;

interface MenuInterface extends ItemContainerInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return ItemInterface[]
     */
    public function getItems();
}
