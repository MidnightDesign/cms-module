<?php

namespace Midnight\CmsModule\Form;

use Zend\Form\Form;

class PageForm extends Form
{
    public function __construct()
    {
        parent::__construct();

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