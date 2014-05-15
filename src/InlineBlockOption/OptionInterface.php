<?php

namespace Midnight\CmsModule\InlineBlockOption;

interface OptionInterface
{
    /**
     * @return string
     */
    public function getHref();

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return string
     */
    public function getClass();
}
