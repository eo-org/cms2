<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'extadmin-template'	=> 'Ext\Controller\TemplateController',
		),
	),
	'view_manager' => array(
		'template_map' => array(
			'ext/template/index'			=> __DIR__ . '/../view-controller/ext/template/index.phtml',
			'ext/template/edit'				=> __DIR__ . '/../view-controller/ext/template/edit.phtml',
			'ext/template/get-tpl-content'	=> __DIR__ . '/../view-controller/ext/template/get-tpl-content.phtml',
		)
	),
	'brick' => array(
		'article' => array(
			'label' => '文章',
			'ext' => array(
				'Ext_Brick_Article_Detail' => array(
					'label' => '文章-内容',
					'desc' => ''
				),
				'Ext_Brick_Article_ContentList' => array(
					'label' => '文章-列表',
					'desc' => ''
				),
				'Ext_Brick_Article_News' => array(
					'label' => '文章-简表',
					'desc' => ''
				),
				'Ext_Brick_Article_GroupIndex' => array(
					'label' => '文章-分组',
					'desc' => ''
				),
				'Ext_Brick_Article_ChildGroupIndex' => array(
					'label' => '文章-子分组',
					'desc' => ''
				),
			)
		),
		'book' => array(
			'label' => '手册',
			'ext' => array(
				'Ext_Brick_Book_Index' => array(
					'label' => '手册-目录',
					'desc' => ''
				),
				'Ext_Brick_Book_PageDetail' => array(
					'label' => '手册-书页内容',
					'desc' => ''
				)
			)
		),
		'product' => array(
			'label' => '产品',
			'ext' => array(
				'Ext_Brick_Product_Detail' => array(
					'label' => '产品-内容',
					'desc' => ''
				),
				'Ext_Brick_Product_ContentList' => array(
					'label' => '产品-列表',
					'desc' => ''
				),
				'Ext_Brick_Product_News' => array(
					'label' => '产品-简表',
					'desc' => ''
				),
				'Ext_Brick_Product_News_Carousel' => array(
					'label' => '产品-简表-滚动',
					'desc' => ''
				),
				'Ext_Brick_Product_GroupIndex' => array(
					'label' => '产品-分组',
					'desc' => ''
				),
				'Ext_Brick_Product_ChildGroupIndex' => array(
					'label' => '产品-子分组',
					'desc' => ''
				),
				'Ext_Brick_Product_Selector' => array(
					'label' => '产品-筛选框',
					'desc' => ''
				),
			)
		),
		'position' => array(
			'lable' => '位置导航',
			'ext' => array(
				'Ext_Brick_Position_Navi' => array(
					'label' => '导航',
					'desc' => ''
				),
				'Ext_Brick_Position_Navi_Dropdown' => array(
					'label' => '导航',
					'desc' => ''
				),
				'Ext_Brick_Position_Breadcrumb' => array(
					'label' => '当前位置',
					'desc' => ''
				)
			)
		),
		'adgroup' => array(
			'lable' => '广告图',
			'ext' => array(
				'Ext_Brick_AdGroup_Plain' => array(
					'label' => '广告图切换',
					'desc' => ''
				),
				'Ext_Brick_AdGroup_Accordion' => array(
					'label' => '广告图切换',
					'desc' => ''
				),
				'Ext_Brick_AdGroup_FancyTransition' => array(
					'label' => '广告图切换',
					'desc' => ''
				),
				'Ext_Brick_AdGroup_Transition' => array(
					'label' => '广告图切换',
					'desc' => ''
				),
				'Ext_Brick_AdGroup_Rotate' => array(
					'label' => '广告图切换',
					'desc' => ''
				),
				'Ext_Brick_AdGroup_Popup' => array(
					'label' => '广告图切换',
					'desc' => ''
				),
				'Ext_Brick_AdGroup_Opacity' => array(
					'label' => '广告图切换',
					'desc' => ''
				),
			)
		),
		'html' => array(
			'label' => 'HTML',
			'ext' => array(
				'Ext_Brick_Html_Html' => array(
					'label' => 'HTML',
					'desc' => ''
				)
			)
		),
		'logo' => array(
			'label' => 'LOGO',
			'ext' => array(
				'Ext_Brick_Logo_Logo' => array(
					'label' => 'HTML',
					'desc' => ''
				)
			)
		),
		'search' => array(
			'label' => '搜索',
			'ext' => array(
				'Ext_Brick_Search_Input' => array(
					'label' => '搜索输入框',
					'desc' => ''
				),
				'Ext_Brick_Search_Result' => array(
					'label' => '搜索结果框',
					'desc' => ''
				)
			)
		),
		'im' => array(
			'label' => 'IM',
			'ext' => array(
				'Ext_Brick_Im_Im' => array(
					'label' => '搜索输入框',
					'desc' => ''
				),
			)
		),
		'other' => array(
			'label' => '其他',
			'ext' => array(
				'Ext_Brick_SpriteSurrogate' => array(
					'label' => 'TAB',
					'desc' => ''
				),
				'Ext_Brick_Attachment' => array(
					'label' => '附件下载',
					'desc' => ''
				),
				'Ext_Brick_ActionContent' => array(
					'label' => '控制器内容输出',
					'desc' => ''
				),
				'Ext_Brick_Player_Player' => array(
					'label' => '播放器',
					'desc' => ''
				)
			)
		)
	),
	'brick_path_stack' => array(__DIR__.'/../view'),
);