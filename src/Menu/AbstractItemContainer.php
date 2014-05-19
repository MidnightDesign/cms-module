<?php

namespace Midnight\CmsModule\Menu;

use Midnight\CmsModule\Menu\Item\ItemInterface;

abstract class AbstractItemContainer implements ItemContainerInterface
{
    /**
     * @var ItemContainerInterface[]
     */
    protected $items = array();

    /**
     * @param array $path
     *
     * @return void
     */
    public function deleteItemByPath(array $path)
    {
        $this->ensureNumericKeys();
        $index = (integer)array_shift($path);
        if (sizeof($path) === 0) {
            unset($this->items[$index]);
        } else {
            $this->items[$index]->deleteItemByPath($path);
        }
    }

    /**
     * @param ItemInterface $item
     * @param array         $path
     *
     * @return void
     */
    public function addItem(ItemInterface $item, array $path = null)
    {
        if (null === $path) {
            $path = array(count($this->getItems()));
        }
        if (count($path) === 1) {
            array_splice($this->items, $path[0], 0, array($item));
        } else {
            $index = (integer)array_shift($path);
            $this->items[$index]->addItem($item, $path);
        }
        $this->ensureNumericKeys();
    }

    /**
     * @return ItemInterface[]
     */
    public function getItems()
    {
        $this->ensureNumericKeys();
        return $this->items;
    }

    /**
     * @todo This is just a dirty hack to avoid problems with the JSON storage when deleting items.
     */
    private function ensureNumericKeys()
    {
        $items = array();
        foreach ($this->items as $item) {
            $items[] = $item;
        }
        $this->items = $items;
    }
} 
