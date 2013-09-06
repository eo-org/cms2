<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'messageadmin-index'		=> 'MessageAdmin\Controller\IndexController',
			'messagerest-messageform'	=> 'MessageRest\Controller\MessageFormController',
		),
	),
	'view_manager' => array(
		'template_map' => array(
			'message-admin/index/index'		=> __DIR__ . '/../view/message-admin/index/index.phtml',
			'message-admin/index/edit'	=> __DIR__ . '/../view/message-admin/index/edit.phtml',
		)
	),
	'brick' => array(
		'message' => array(
			'label' => '表单信息',
			'ext' => array( 
				'Message_Brick_Form' => array(
					'label' => '信息表单',
					'desc' => ''
				)
			)
		)
	),
	'brick_path_stack' => array(
		__DIR__.'/../view/brick',
	),
	'admin_toolbar' => array(
		'navifefe' => array(
			'title' => 'MESSAGE',
			'url' => '/admin/messageadmin-index/',
		),
	),
	'twig' => array(
		'functions' => array(
			'printElements' => function($messageForm) { return $messageForm->render(); }
		)
	)
);
