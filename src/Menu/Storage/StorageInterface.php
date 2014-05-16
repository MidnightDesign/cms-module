<?php

namespace Midnight\CmsModule\Menu\Storage;

use Midnight\CmsModule\Menu\MenuInterface;

interface StorageInterface
{
    /**
     * @param string $id
     *
     * @return MenuInterface
     */
    public function load($id);

    /**
     * @param MenuInterface $menu
     *
     * @return void
     */
    public function save(MenuInterface $menu);
}
