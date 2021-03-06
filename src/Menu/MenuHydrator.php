<?php

namespace Midnight\CmsModule\Menu;

use Zend\Stdlib\Hydrator\Reflection;

class MenuHydrator extends Reflection
{
    public function extract($object)
    {
        $data = parent::extract($object);
        foreach ($data as &$val) {
            if (is_object($val)) {
                $val = $this->extract($val);
            } elseif (is_array($val)) {
                foreach ($val as &$val2) {
                    if (is_object($val2)) {
                        $val2 = $this->extract($val2);
                    }
                }
            }
        }
        $data['class'] = get_class($object);
        return $data;
    }

    public function hydrate(array $data, $object)
    {
        foreach ($data as $key => &$val) {
            if (is_array($val)) {
                foreach ($val as $key2 => &$val2) {
                    if (!empty($val2['class'])) {
                        $class = $val2['class'];
                        $o = new $class();
                        $this->hydrate($val2, $o);
                        $data[$key][$key2] = $o;
                    }
                }
            }
        }
        return parent::hydrate($data, $object); // TODO: Change the autogenerated stub
    }
} 
