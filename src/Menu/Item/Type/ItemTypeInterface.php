<?php

namespace Midnight\CmsModule\Menu\Item\Type;

interface ItemTypeInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getKey();

    /**
     * @return string
     */
    public function getControllerName();
}
