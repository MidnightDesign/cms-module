<?php

namespace Midnight\CmsModule\InlineBlockOption;

/**
 * Class Option
 * @package Midnight\CmsModule\InlineBlockOption
 *
 * Standard implementation of OptionInterface
 */
class Option implements OptionInterface
{
    /**
     * @var
     */
    private $href;
    /**
     * @var
     */
    private $label;
    /**
     * @var string[]
     */
    private $classes = array();

    /**
     * @return mixed
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param mixed $href
     */
    public function setHref($href)
    {
        $this->href = $href;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Accepts any of these formats for $class:
     *
     * * "foo"
     * * "foo bar" (Two classes)
     * * ["foo", "bar"] (Two classes)
     *
     * @param string|string[] $class
     */
    public function addClass($class)
    {
        if (is_string($class) && strstr($class, ' ') !== false) {
            $class = explode(' ', $class);
        }
        if (is_array($class)) {
            foreach ($class as $c) {
                $this->addClass($c);
            }
            return;
        }
        if (trim($class)) {
            $this->classes[] = $class;
            $this->classes = array_unique($this->classes);
        }
    }

    /**
     * @return string
     */
    public function getClass()
    {
        if (empty($this->classes)) {
            return null;
        }
        return join(' ', $this->classes);
    }
}
