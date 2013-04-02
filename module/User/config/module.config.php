<?php
return array(
	'service_manager' => array(
		'invokables' => array(
			'User\SessionUser' => 'User\SessionUser',
		)
	),
    'controllers' => array(
        'invokables' => array(
            'user-index'			=> 'User\Controller\IndexController',
			'user-order'			=> 'User\Controller\OrderController',
			'user-address'			=> 'User\Controller\AddressController',
        	/*admin panel controllers*/
        	'useradmin-index'		=> 'UserAdmin\Controller\IndexController',
        	'useradmin-user'		=> 'UserAdmin\Controller\UserController',
        	'useradmin-address'		=> 'UserAdmin\Controller\AddressController',
        	'useradmin-user-group'	=> 'UserAdmin\Controller\UserGroupController',
        	/*rest controllers*/
        	'userrest-user'			=> 'UserRest\Controller\UserController',
        	'userrest-user-group'	=> 'UserRest\Controller\UserGroupController',
        ),
    ),
    'view_manager' => array(
		'template_map' => array(
			'user/action'					=> __DIR__ . '/../view/user/user-action.phtml',
			'user/index/index'				=> __DIR__ . '/../view/user/index/index.phtml',
			'user/index/login'				=> __DIR__ . '/../view/user/index/login.phtml',
			'user/index/register'			=> __DIR__ . '/../view/user/index/register.phtml',
			'user/index/change-password'	=> __DIR__ . '/../view/user/index/change-password.phtml',
			'user/address/index'			=> __DIR__ . '/../view/user/address/index.phtml',
			/*admin tpl*/
			'user-admin/index/index'		=> __DIR__ . '/../view/user-admin/index/index.phtml',
			'user-admin/index/config'		=> __DIR__ . '/../view/user-admin/index/config.phtml',
			'user-admin/user/index'			=> __DIR__ . '/../view/user-admin/user/index.phtml',
			'user-admin/user/edit'			=> __DIR__ . '/../view/user-admin/user/edit.phtml',
			'user-admin/user-group/index'	=> __DIR__ . '/../view/user-admin/user-group/index.phtml',
			'user-admin/user-group/edit'	=> __DIR__ . '/../view/user-admin/user-group/edit.phtml',
		)
    ),
    'router' => array(
        'routes' => array(
            'user' => array(
    			'type' => 'literal',
    			'options' => array(
    				'route' => '/user',
    				'defaults' => array(
    					'controller' => 'user-index',
    					'action' => 'index'
    				)
    			),
    			'may_terminate' => true,
    			'child_routes' => array(
		    		'order' => array(
    					'type'    => 'segment',
		                'options' => array(
		                    'route'    => '[:controller][/:action]',
		                	
		                ),
						'params'  => array(
							'params' => array(
								'type' => 'wildcard',
							),
						),
    				),
    			)
            ),
        ),
    ),
	'brick' => array(
		'user' => array(
			'label' => '其他',
			'ext' => array(
				'Ext_Brick_ActionContent' => array(
					'label' => '用户界面内容输出',
					'desc' => ''
				),
			)
		)
	),
);