<?php

namespace Midnight\CmsModule;

$routes = include __DIR__ . '/routes.config.php';
$cms = include __DIR__ . '/cms.config.php';

return array(
    'cms' => $cms,
    'router' => array(
        'routes' => $routes,
    ),
    'controllers' => array(
        'invokables' => array(
            __NAMESPACE__ . 'Page' => __NAMESPACE__ . '\Controller\PageController',
            __NAMESPACE__ . 'PageAdmin' => __NAMESPACE__ . '\Controller\PageAdminController',
            __NAMESPACE__ . 'BlockAdmin' => __NAMESPACE__ . '\Controller\BlockAdminController',
            __NAMESPACE__ . 'Block\Html' => __NAMESPACE__ . '\Controller\Block\HtmlController',
            __NAMESPACE__ . '\MenuAdmin' => __NAMESPACE__ . '\Menu\Controller\MenuAdminController',
            __NAMESPACE__ . '\Menu\Controller\Item\Page' => __NAMESPACE__ . '\Menu\Controller\Item\PageController',
        ),
    ),
    'navigation' => array(
        'admin' => array(
            array(
                'label' => 'Pages',
                'route' => 'zfcadmin/cms',
            ),
            array(
                'label' => 'Menu',
                'route' => 'zfcadmin/cms/menu',
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
            'blockList' => 'Midnight\CmsModule\View\Helper\BlockListFactory',
            'blockPreview' => 'Midnight\CmsModule\View\Helper\BlockPreviewFactory',
            'htmlBlock' => 'Midnight\CmsModule\View\Helper\HtmlBlockFactory',
            'cmsMenu' => 'Midnight\CmsModule\Menu\View\Helper\CmsMenuFactory',
            'page' => 'Midnight\CmsModule\View\Helper\PageFactory',
        ),
        'invokables' => array(
            'htmlBlockPreview' => 'Midnight\CmsModule\View\Helper\HtmlBlockPreview',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'cms.block_type_manager' => 'Midnight\CmsModule\Service\BlockTypeManagerFactory',
            'cms.page_storage' => 'Midnight\CmsModule\Storage\PageStorageFactory',
            'cms.block_storage' => 'Midnight\CmsModule\Storage\BlockStorageFactory',
            'cms.menu.storage' => 'Midnight\CmsModule\Menu\Storage\StorageFactory',
            'cms.menu.item_type_manager' => 'Midnight\CmsModule\Menu\Item\Type\ItemTypeManagerFactory',
        ),
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                dirname(__DIR__) . '/public',
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . 'mongodb' => array(
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => array(dirname(__DIR__) . '/mapping/mongodb'),
            ),
            __NAMESPACE__ . 'orm' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => array(dirname(__DIR__) . '/mapping/orm'),
            ),
            'odm_default' => array(
                'drivers' => array(
                    'Midnight\Page' => __NAMESPACE__ . 'mongodb',
                    'Midnight\Block' => __NAMESPACE__ . 'mongodb',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Midnight\Page' => __NAMESPACE__ . 'orm',
                    'Midnight\Block' => __NAMESPACE__ . 'orm',
                ),
            ),
        ),
    ),
    'zfc_rbac' => array(
        'role_provider' => array(
            'ZfcRbac\Role\InMemoryRoleProvider' => array(
                'admin' => array(
                    'permissions' => array(
                        'cms.block.edit',
                        'cms.block.html.edit',
                        'cms.page.add_block',
                        'cms.page.edit',
                    ),
                ),
            ),
        ),
    ),
);
