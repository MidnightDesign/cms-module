<?php

namespace Midnight\CmsModule\Menu;

interface ItemContainerInterface
{
    /**
     * @param array $path
     *
     * @return void
     */
    public function deleteItemByPath(array $path);
} 
