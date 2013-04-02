<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'rest-disqus-post'		=> 'Disqus\Controller\PostController',
			'disqusadmin-index'		=> 'DisqusAdmin\Controller\IndexController',
			'disqusadmin-thread'	=> 'DisqusAdmin\Controller\ThreadController',
			'disqusrest-thread'		=> 'DisqusRest\Controller\ThreadController',
			'disqusrest-post'		=> 'DisqusRest\Controller\PostController',
		),
	),
	'view_manager' => array(
		'template_map' => array(
			'disqus-admin/index/index'	=> __DIR__ . '/../view/disqus-admin/index/index.phtml',
			'disqus-admin/thread/index'	=> __DIR__ . '/../view/disqus-admin/thread/index.phtml',
			'disqus-admin/thread/edit'	=> __DIR__ . '/../view/disqus-admin/thread/edit.phtml',
		)
	),
	'brick' => array(
		'disqus' => array(
			'label' => '留言回复',
			'ext' => array( 
				'Disqus_Brick_Thread' => array(
					'label' => '留言回复',
					'desc' => ''
				)
			)
		)
	),
	'brick_path_stack' => array(
		__DIR__.'/../view/brick',
	)
);
