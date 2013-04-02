<?php
namespace Admin\Form\Article;

use Zend\Form\Form;

class EditForm extends Form
{
    public function __construct()
    {
    	parent::__construct('article-edit');
    	
    	$this->add(array(
    		'name' => 'label',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => '文章名')
    	));
    	$this->add(array(
    		'name' => 'groupId',
    		'type' => 'Zend\Form\Element\Select',
    		'options' => array('label' => '文章分类')
    	));
    	$this->add(array(
    		'name' => 'fulltext',
    		'attributes' => array(
    			'type' => 'textarea',
    			'class' => 'ckeditor',
    		),
    		'options' => array('label' => '文章内容')
    	));
    	$this->add(array(
    		'name' => 'appendImage',
    		'type' => 'Zend\Form\Element\Button',
    		'attributes' => array(
    			'class' => 'icon-selector',
    			'data-callback' => 'appendToEditor'
    		),
    		'options' => array('label' => '插入图片', 'callback' => 'appendToEditor',)
    	));
    	$this->add(array(
    		'name' => 'status',
    		'attributes' => array('type' => 'hidden', 'value' => 'publish')
    	));
    	$this->add(array(
    		'name' => 'created',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => '创建时间')
    	));
    	$this->add(array(
    		'name' => 'introtext',
    		'attributes' => array('type' => 'textarea'),
    		'options' => array('label' => '文章摘要')
    	));
    	$this->add(array(
    		'name' =>'metakey',
			'attributes' => array('type' => 'textarea'),
    		'options' => array('label' => '内容关键词')
        ));
        $this->add(array(
        	'name' => 'introicon',
        	'attributes' => array('type' => 'hidden', 'id' => 'introicon')
        ));
    }
    
    public function getTabSettings()
    {
    	return array(
    		array('handleLabel' => '基本信息', 'content' => array('label', 'groupId', 'fulltext', 'appendImage', 'status')),
    		array('handleLabel' => '选填信息', 'content' => array('created', 'introtext', 'metakey', 'introicon'))
    	);
    }
}