<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'locationadmin-index'		=> 'LocationAdmin\Controller\IndexController',
			'locationrest-location'		=> 'LocationRest\Controller\LocationController',
		),
	),
	'view_manager' => array(
		'template_map' => array(
			'location-admin/index/index'	=> __DIR__ . '/../view/location-admin/index/index.phtml',
		)
	),
);
