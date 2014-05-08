<?php

namespace Midnight\CmsModule\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\Reflection;

class PageForm extends Form
{
    public function __construct()
    {
        parent::__construct();

        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => 'Titel',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Seite erstellen',
            ),
        ));
    }

} 