<?php

namespace Midnight\CmsModule;

return array(
    'storage' => array(
        'page' => array(
            'type' => 'Midnight\Page\Storage\Doctrine',
            'options' => array(
                'object_manager' => 'doctrine.documentmanager.odm_default',
            ),
        ),
        'block' => array(
            'type' => 'Midnight\Block\Storage\Doctrine',
            'options' => array(
                'object_manager' => 'doctrine.documentmanager.odm_default',
            ),
        ),
    ),
    'blocks' => array(
        'html' => array(
            'name' => 'Text',
            'class' => 'Midnight\Block\Html',
            'controller' => __NAMESPACE__ . 'Block\Html',
            'renderer' => 'htmlBlock',
            'preview_renderer' => 'htmlBlockPreview',
        ),
    ),
    'menu' => array(
        'storage' => array(
            'type' => 'Midnight\CmsModule\Menu\Storage\JsonStorage',
            'options' => array(
                'directory' => 'data/menus',
            ),
        ),
        'item_types' => array(
            'page' => array(
                'name' => 'CMS Page',
                'controller' => __NAMESPACE__ . '\Menu\Controller\Item\Page',
            ),
        ),
    ),
);
