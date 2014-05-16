<?php

namespace Midnight\CmsModule;

return array(
    'cms_page' => array(
        'type' => 'Segment',
        'options' => array(
            'route' => '/:page_id',
            'defaults' => array(
                'controller' => __NAMESPACE__ . 'Page',
                'action' => 'view',
            ),
        ),
    ),
    'zfcadmin' => array(
        'child_routes' => array(
            'cms' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/cms',
                    'defaults' => array(
                        'controller' => __NAMESPACE__ . 'PageAdmin',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'page' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/pages',
                            'defaults' => array(
                                'controller' => __NAMESPACE__ . 'PageAdmin',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'create' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/create',
                                    'defaults' => array('action' => 'create'),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/:page_id/edit',
                                    'defaults' => array('action' => 'edit'),
                                ),
                            ),
                            'delete_block' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/delete-block/:page_id/:block_id',
                                    'defaults' => array('action' => 'delete-block'),
                                ),
                            ),
                            'move_block' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/move-block/:page_id/:block_id',
                                    'defaults' => array('action' => 'move-block'),
                                ),
                            ),
                        ),
                    ),
                    'block' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/blocks',
                            'defaults' => array(
                                'controller' => __NAMESPACE__ . 'BlockAdmin',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'create' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/create[/:block_type]',
                                    'defaults' => array('action' => 'create'),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:block_id',
                                    'defaults' => array('action' => 'edit'),
                                ),
                            ),
                            'set_html' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/set-html/:block_id',
                                    'defaults' => array(
                                        'controller' => __NAMESPACE__ . 'Block\Html',
                                        'action' => 'set-html',
                                    ),
                                ),
                            )
                        ),
                    ),
                    'menu' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/menu',
                            'defaults' => array(
                                'controller' => __NAMESPACE__ . '\MenuAdmin',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/:menu_id/edit',
                                    'defaults' => array('action' => 'edit'),
                                ),
                            ),
                            'create_item' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/:menu_id/create-item[/:item_type]',
                                    'defaults' => array('action' => 'create-item'),
                                ),
                            ),
                            'delete_item' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/:menu_id/delete-item[/:path]',
                                    'defaults' => array('action' => 'delete-item'),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
