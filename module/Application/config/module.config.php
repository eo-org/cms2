<?php
return array(
	'controllers' => array(
        'invokables' => array(
            'Application\Controller' => 'Cms\ApplicationController',
//        	'Application\Controller' => 'Application\Controller\IndexController',
        	'Application\Controller\Error' => 'Application\Controller\ErrorController',
        ),
    ),
    'router' => array(
        'routes' => array(
        	'rest' => array(
        		'type' => 'Literal',
        		'options' => array(
        			'route'    => '/rest',
        		),
        		'may_terminate' => true,
        		'child_routes' => array(
        			'restchildroutes' => array(
        				'type' => 'segment',
        				'options' => array(
        					'route' => '[/:controller].[:format][/:id]',
        					'constraints' => array(
        						'controller' => '[a-z-]*',
        						'format' => '(json|html)',
        						'id' => '[a-z0-9]*'
        					)
        				),
        			),
        		),
        	),
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller'    => 'Application\Controller',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'book' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[:id][/:pageId].shtml',
                			'constraints' => array(
		            			'id' => '[a-z0-9]*',
                				'pageId' => '[a-z0-9]*'
		            		)
                        ),
                    ),
                    'article' => array(
                    	'type'    => 'Segment',
		            	'options' => array(
		            		'route' => 'article-[:id].shtml',
		            		'constraints' => array(
		            			'id' => '[a-z0-9]*',
		            		)
		            	)
		            ),
		            'list' => array(
		            	'type'    => 'Segment',
		            	'options' => array(
		            		'route' => 'list-[:id]/page[:page].shtml',
		            		'constraints' => array(
		            			'id' => '[a-z0-9]*',
		            			'page' => '[0-9]*'
		            		)
		            	)
		            ),
		            'product' => array(
		            	'type'    => 'Segment',
		            	'options' => array(
		            		'route' => 'product-[:id].shtml',
		            		'constraints' => array(
		            			'id' => '[a-z0-9]*',
		            		)
		            	)
		            ),
		            'product-list' => array(
		            	'type'    => 'Segment',
		            	'options' => array(
		            		'route' => 'product-list-[:id]/page[:page].shtml',
		            		'constraints' => array(
		            			'id' => '[a-z0-9]*',
		            			'page' => '[0-9]*'
		            		)
		            	)
		            ),
		            'search' => array(
		            	'type'    => 'Literal',
		            	'options' => array(
		            		'route' => 'search.shtml',
		            	)
		            ),
                	'frontpage' => array(
                		'type'		=> 'Segment',
                		'options'	=> array(
                			'route' => '[:id].htm',
                			'constraints' => array(
                				'id' => '[a-z0-9]*'
                			)
                		)
                	),
                	'layout' => array(
                		'type'		=> 'Segment',
                		'options'	=> array(
                			'route' => '[:id].layout',
                			'constraints' => array(
                				'id' => '[a-z0-9]*'
                			)
                		)
                	)
                ),
            ),
        	'error' => array(
        		'type'    => 'Segment',
        		'options' => array(
        			'route'    => '/error-[:id].shtml',
        			'defaults' => array(
        				'controller'    => 'Application\Controller',
        				'action'        => 'index',
        			),
        			'constraints' => array(
        				'id' => '(401|404)'
        			)
        		),
        		'may_terminate' => true,
        	),
        ),
    ),
    'controller_plugins' => array(
    	'invokables' => array(
    		'brickConfig'		=> 'Brick\Helper\Controller\Config',
    		'dbFactory'			=> 'Core\Controller\Plugin\DbFactory',
    		'documentManager'	=> 'Core\Controller\Plugin\DocumentManager',
    		'switchContext'		=> 'Core\Controller\Plugin\SwitchContext',
    		'siteConfig'		=> 'Core\Controller\Plugin\SiteConfig',
    		'formatData'		=> 'Core\Controller\Plugin\FormatData',
    	)
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
    		'layout/error'				=> __DIR__ . '/../view/layout/error.phtml',
            'layout/layout'				=> __DIR__ . '/../view/layout/layout.phtml',
        	'layout/body'				=> __DIR__ . '/../view/layout/body.phtml',
        	'layout/head-client'		=> __DIR__ . '/../view/layout/head-client.phtml',
    		'layout/head-admin'			=> __DIR__ . '/../view/layout/head-admin.phtml',
    		'layout/toolbar'			=> __DIR__ . '/../view/layout/toolbar.phtml',
            'application/index/index'	=> __DIR__ . '/../view/application/index/index.phtml',
            'error/404'					=> __DIR__ . '/../view/error/404.phtml',
            'error/index'				=> __DIR__ . '/../view/error/index.phtml',
        ),
    	'strategies' => array(
    		'ViewJsonStrategy'
    	),
    ),
    'view_helpers' => array(
        'invokables' => array(
    		'singleForm'			=> 'Core\View\Helper\SingleForm',
    		'brickConfigForm'		=> 'Core\View\Helper\BrickConfigForm',
            'tabForm'				=> 'Core\View\Helper\TabForm',
            'bootstrapRow'			=> 'Core\View\Helper\BootstrapRow',
            'bootstrapCollection'	=> 'Core\View\Helper\BootstrapCollection',
    		'outputImage'			=> 'Core\View\Helper\OutputImage',
    		'siteConfig'			=> 'Core\View\Helper\SiteConfig',
    		'selectOptions'			=> 'Core\View\Helper\SelectOptions',
        ),
    ),
	'service_manager' => array(
		'factories' => array(
			'ConfigObject\EnvironmentConfig' => function($serviceManager) {
				$siteConfig = new \Fucms\SiteConfig(include 'config/server.config.php.dist');
				return $siteConfig;
			},
			'Cms\Layout\Front' => 'Cms\Layout\FrontFactory',
		),
// 		'invokables' => array(
// 			'Fucms\Session\Admin' => 'Fucms\Session\Admin',
// 		)
	),
);
