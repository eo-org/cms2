<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'index'			=> 'Admin\Controller\IndexController',
			'navi'			=> 'Admin\Controller\NaviController',
			'article'		=> 'Admin\Controller\ArticleController',
			'book'			=> 'Admin\Controller\BookController',
			'product-type'	=> 'Admin\Controller\ProductTypeController',
        	'product-brand'	=> 'Admin\Controller\ProductBrandController',
			'product'		=> 'Admin\Controller\ProductController',
			'ad-section'	=> 'Admin\Controller\AdSectionController',
			'ad'			=> 'Admin\Controller\AdController',
			'user'			=> 'Admin\Controller\UserController',
			'system'		=> 'Admin\Controller\SystemController',
			'site'			=> 'Admin\Controller\SiteController',
			'brick'			=> 'Admin\Controller\BrickController',
			'group'			=> 'Admin\Controller\GroupController',
			'layout'		=> 'Admin\Controller\LayoutController',
        	'attributeset'	=> 'Admin\Controller\AttributesetController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
        'template_map' => array(
        	'layout-admin/layout'	=> __DIR__ . '/../view/layout/layout.phtml',
        	'layout-admin/ajax'		=> __DIR__ . '/../view/layout/layout.ajax.phtml',
        	'layout-admin/bone'		=> __DIR__ . '/../view/layout/layout.bone.phtml',
    		'layout/head'			=> __DIR__ . '/../view/layout/head.phtml',
        	'layout/admin-toolbar'	=> __DIR__ . '/../view/layout/toolbar.phtml',
        ),
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
    			'type' => 'literal',
    			'options' => array(
    				'route' => '/admin',
    				'defaults' => array(
    					'controller' => 'index',
    					'action' =>'index',
    				)
    			),
    			'may_terminate' => true,
    			'child_routes' => array(
    				'formatroutes' => array(
    					'type' => 'segment',
    					'options' => array(
    						'route' => '[/:controller[.:format]][/:action]',
    						'constraints' => array(
    							'controller' => '[a-z-]*',
    							'format' => '(ajax|bone)',
    							'action' => '[a-z-]*'
    						),
    					),
    					'child_routes' => array(
    						'wildcard' => array(
    							'type' => 'wildcard',
    						),
    					),
    				),
		    		'actionroutes' => array(
    					'type' => 'segment',
		                'options' => array(
		                    'route' => '[/:controller][/:action]',
		                    'constraints' => array(
		    					'controller' => '[a-z-]*',
		                        'action' => '[a-z-]*'
		                    ),
		                	'defaults' => array(
		                		'action' => 'index'
		                	)
		                ),
						'child_routes' => array(
							'wildcard' => array(
								'type' => 'wildcard',
							),
						),
    				),
    				
    			)
            ),
        ),
    ),
	'admin_toolbar' => array(
		'navi' => array(
			'title' => '目录导航',
			'url' => '/admin/navi/',
// 			'children' => array()
		),
		'article' => array(
			'title' => '内容管理',
			'url' => '/admin/article/',
// 			'children' => array(
// 				'product-group' => array(
// 					'title' => '产品目录',
// 					'url' => '/admin/group/edit/type/article'
// 				)
// 			)
		),
		'book' => array(
			'title' => '手册管理',
			'url' => '/admin/book/',
		),
		'product' => array(
			'title' => '产品管理',
			'url' => '/admin/product/',
// 			'children' => array(
// 				'product-group' => array(
// 					'title' => '产品目录dededededede',
// 					'url' => '/admin/group/edit/type/product'
// 				)
// 			)
		),
		'ad-section' => array(
			'title' => '广告管理',
			'url' => '/admin/ad-section/',
		),
		'system' => array(
			'title' => '系统管理',
			'url' => '/admin/system/',
		),
		'brick' => array(
			'title' => '模块管理',
			'url' => '/admin/brick/',
		),
		'useradmin-user' => array(
			'title' => '用户管理',
			'url' => '/admin/useradmin-user/',
		),
		'disqusadmin-thread' => array(
			'title' => 'DISQUS',
			'url' => '/admin/disqusadmin-thread',
		),
		'file' => array(
			'title' => '文件管理',
			'url' => 'http://file.enorange.com/{{remoteSiteId}}/admin/',
		),
		'message' => array(
			'title' => '留言管理',
			'url' => 'http://form.enorange.cn/{{remoteSiteId}}/admin/',
		)
	)
);