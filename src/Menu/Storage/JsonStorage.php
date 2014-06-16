<?php

namespace Midnight\CmsModule\Menu\Storage;

use Exception;
use Midnight\CmsModule\Menu\MenuHydrator;
use Midnight\CmsModule\Menu\MenuInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Stdlib\Parameters;
use Zend\Stdlib\ParametersInterface;

class JsonStorage implements StorageInterface
{
    /**
     * @var ParametersInterface
     */
    private $options;

    /**
     * @param ParametersInterface|array $options
     */
    public function __construct($options)
    {
        if (is_array($options)) {
            $options = new Parameters($options);
        }
        if (!$options instanceof ParametersInterface) {
            throw new \InvalidArgumentException('Expected $options to be Zend\Stdlib\ParametersInterface or array.');
        }
        $this->options = $options;
    }

    /**
     * @param string $id
     *
     * @return MenuInterface|null
     */
    public function load($id)
    {
        $path = $this->getPath($id);
        if (!file_exists($path)) {
            return null;
        }
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        $menuClass = $data['class'];
        $menu = new $menuClass();
        $this->getHydrator()->hydrate($data, $menu);
        return $menu;
    }

    /**
     * @param MenuInterface $menu
     *
     * @throws Exception
     * @return void
     */
    public function save(MenuInterface $menu)
    {
        $data = $this->getData($menu);
        $data['class'] = get_class($menu);
        $json = json_encode($data, JSON_PRETTY_PRINT);
        $bytesWritten = file_put_contents($this->getPath($menu->getId()), $json);
        if (false === $bytesWritten) {
            throw new Exception(sprintf('Couldn\'t save menu "%s".', $menu->getId()));
        }
    }

    /**
     * @param string $id
     *
     * @return string
     */
    private function getPath($id)
    {
        return $this->options->get('directory') . '/' . $id . '.json';
    }

    /**
     * @return HydratorInterface
     */
    private function getHydrator()
    {
        return new MenuHydrator();
    }

    /**
     * @param object $object
     *
     * @return array
     */
    private function getData($object)
    {
        $hydrator = $this->getHydrator();
        $data = $hydrator->extract($object);
        return $data;
    }
}
