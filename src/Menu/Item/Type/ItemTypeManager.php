<?php

namespace Midnight\CmsModule\Menu\Item\Type;

class ItemTypeManager implements ItemTypeManagerInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var ItemTypeInterface[]
     */
    private $types;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return ItemTypeInterface[]
     */
    public function getTypes()
    {
        $this->init();
        return $this->types;
    }

    /**
     * Returns an item type by key
     *
     * @param string $key
     *
     * @return ItemTypeInterface
     */
    public function get($key)
    {
        $this->init();
        return $this->types[$key];
    }

    private function init()
    {
        if (!empty($this->types)) {
            return;
        }
        foreach ($this->config as $key => $typeConfig) {
            $type = new ItemType();
            $type->setKey($key);
            $type->setName($typeConfig['name']);
            $type->setController($typeConfig['controller']);
            $this->types[$type->getKey()] = $type;
        }
    }
}
