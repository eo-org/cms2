<?php
namespace Admin\Form\Layout;

use Zend\Form\Form;

class CreateForm extends Form
{
    public function __construct()
    {
    	parent::__construct('layout-create');
    	
    	$this->add(array(
    		'name' => 'label',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => '标题[中文]')
    	));
    	$this->add(array(
    		'name' => 'type',
    		'type' => 'Zend\Form\Element\Select',
    		'options' => array('label' => '数据类型', 'value_options' => array(
    			'index' => '综合页面',
				'list' => '文章列表',
				'product-list' => '产品列表',
				'book' => '手册'
    		))
    	));
    	$this->add(array(
    		'name' => 'alias',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => 'LAYOUT别名[a-z]')
		));
    }
}