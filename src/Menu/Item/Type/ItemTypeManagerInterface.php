<?php

namespace Midnight\CmsModule\Menu\Item\Type;

interface ItemTypeManagerInterface
{
    /**
     * @return ItemTypeInterface[]
     */
    public function getTypes();

    /**
     * Returns an item type by key
     *
     * @param string $key
     *
     * @return ItemTypeInterface
     */
    public function get($key);
}
