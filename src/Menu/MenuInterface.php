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
     * @param ItemInterface $item
     *
     * @return void
     */
    public function addItem(ItemInterface $item);

    /**
     * @return ItemInterface[]
     */
    public function getItems();
}
