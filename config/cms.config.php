<?php

namespace Midnight\CmsModule;

return array(
    'storage' => array(
        'page' => array(
            'type' => 'Midnight\Page\Storage\Filesystem',
            'options' => array(
                'directory' => 'data/cms/pages',
            ),
        ),
        'block' => array(
            'type' => 'Midnight\Block\Storage\Filesystem',
            'options' => array(
                'directory' => 'data/cms/blocks',
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
        'default_menu_id' => 'default',
        'max_depth' => 2,
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
