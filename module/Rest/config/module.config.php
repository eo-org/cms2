<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'adminrest-navi'		=> 'Rest\Controller\NaviController',
			'adminrest-article'		=> 'Rest\Controller\ArticleController',
			'adminrest-book'		=> 'Rest\Controller\BookController',
			//'adminrest-product-type'=> 'Rest\Controller\ProductTypeController',
			'adminrest-product'		=> 'Rest\Controller\ProductController',
			'adminrest-product-brand'	=> 'Rest\Controller\ProductBrandController',
			'adminrest-ad-section'	=> 'Rest\Controller\AdSectionController',
			'adminrest-ad'			=> 'Rest\Controller\AdController',
			'adminrest-user'		=> 'Rest\Controller\UserController',
			'adminrest-brick'		=> 'Rest\Controller\BrickController',
			'adminrest-treeleaf'	=> 'Rest\Controller\TreeleafController',
			'adminrest-head-file'	=> 'Rest\Controller\HeadFileController',
			'adminrest-group'		=> 'Rest\Controller\GroupController',
			'adminrest-layout'		=> 'Rest\Controller\LayoutController',
			'adminrest-domain'		=> 'Rest\Controller\DomainController',
			'adminrest-attribute'	=> 'Rest\Controller\AttributeController',
			'adminrest-attributeset'=> 'Rest\Controller\AttributesetController',
		)
	),
	'router' => array(
		'routes' => array(
			'adminrest' => array(
				'type' => 'literal',
    			'options' => array(
    				'route' => '/adminrest'
    			),
    			'may_terminate' => true,
    			'child_routes' => array(
    				'adminrest-childroutes' => array(
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
				)
			),
		),
	),
	'view_manager' => array(
		'strategies' => array(
			'ViewJsonStrategy'
		),
	),
);