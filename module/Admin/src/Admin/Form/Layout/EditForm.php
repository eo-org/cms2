<?php
namespace Admin\Form\Layout;

use Zend\Form\Form;

class EditForm extends Form
{
    public function __construct()
    {
    	parent::__construct('layout-edit');
    	
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
    	
    	$this->add(array(
    		'name' => 'useTpl',
    		'type' => 'Zend\Form\Element\Checkbox',
    		'options' => array('label' => '使用TPL')
    	));
    	$this->add(array(
    		'name' => 'tplFileContent',
    		'attributes' => array('type' => 'textarea', 'id' => 'codemirror-editor'),
    		'options' => array('label' => 'TPL文件内容')
    	));
    }
}