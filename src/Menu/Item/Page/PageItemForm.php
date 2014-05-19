<?php

namespace Midnight\CmsModule\Menu\Item\Page;

use Midnight\CmsModule\Menu\MenuInterface;
use Midnight\Page\Storage\StorageInterface;
use Zend\Form\Element\Select;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\Reflection;

class PageItemForm extends Form
{
    public function __construct(StorageInterface $pageStorage, MenuInterface $menu)
    {
        parent::__construct();

        $this->setHydrator(new Reflection());

        $pagesSelect = new Select('page_id', array('label' => 'Target'));
        $options = array();
        $pages = $pageStorage->getAll();
        foreach ($pages as $page) {
            $options[$page->getId()] = $page->getName();
        }
        $pagesSelect->setValueOptions($options);
        $this->add($pagesSelect);

        $this->add(array(
            'type' => 'Hidden',
            'name' => 'menu_id',
            'attributes' => array(
                'value' => $menu->getId()
            ),
        ));

        $this->add(array(
            'type' => 'Hidden',
            'name' => 'path',
        ));

        $this->add(array(
            'type' => 'Submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Create item'
            ),
        ));
    }

} 
