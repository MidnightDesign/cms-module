<?php

namespace Midnight\CmsModule;

return array(
    'router' => array(
        'routes' => array(
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
            __NAMESPACE__ . 'PageAdmin' => __NAMESPACE__ . '\Controller\PageAdminController',
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
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                dirname(__DIR__) . '/public',
            ),
        ),
    ),
);
