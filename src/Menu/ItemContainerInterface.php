<?php

namespace Midnight\CmsModule\Menu;

use Midnight\CmsModule\Menu\Item\ItemInterface;

interface ItemContainerInterface
{
    /**
     * @param array $path
     *
     * @return void
     */
    public function deleteItemByPath(array $path);

    /**
     * @return ItemInterface
     */
    public function getItems();

    /**
     * @param ItemInterface $item
     * @param array         $path
     *
     * @return void
     */
    public function addItem(ItemInterface $item, array $path = null);
} 
