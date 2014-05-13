<?php

namespace Midnight\CmsModule;

return array(
    'router' => array(
        'routes' => array(
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
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            __NAMESPACE__ . 'Page' => __NAMESPACE__ . '\Controller\PageController',
            __NAMESPACE__ . 'PageAdmin' => __NAMESPACE__ . '\Controller\PageAdminController',
            __NAMESPACE__ . 'BlockAdmin' => __NAMESPACE__ . '\Controller\BlockAdminController',
            __NAMESPACE__ . 'Block\Html' => __NAMESPACE__ . '\Controller\Block\HtmlController',
        ),
    ),
    'navigation' => array(
        'admin' => array(
            array(
                'label' => 'Seiten',
                'route' => 'zfcadmin/cms',
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'block' => 'Midnight\CmsModule\View\Helper\BlockFactory',
            'htmlBlock' => 'Midnight\CmsModule\View\Helper\HtmlBlockFactory',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'cms.block_type_manager' => 'Midnight\CmsModule\Service\BlockTypeManagerFactory',
        ),
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                dirname(__DIR__) . '/public',
            ),
        ),
    ),
    'cms' => array(
        'blocks' => array(
            'html' => array(
                'name' => 'HTML',
                'class' => 'Midnight\Block\Html',
                'controller' => __NAMESPACE__ . 'Block\Html',
                'renderer' => 'htmlBlock',
            ),
        ),
    ),
);
