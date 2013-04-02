<?php
namespace Admin\Form\Book\Page;

use Zend\Form\Form;

class EditForm extends Form
{
    public function __construct()
    {
    	parent::__construct('book-page-edit');
    	
    	$this->add(array(
    		'name' => 'label',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => '书页名')
    	));
        $this->add(array(
    		'name' => 'fulltext',
    		'attributes' => array(
    			'type' => 'textarea',
    			'class' => 'ckeditor',
    		),
    		'options' => array('label' => '书页内容')
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
    		'name' => 'alias',
    		'attributes' => array(
    			'type' => 'text'
    		),
    		'options' => array('label' => '手册书页别名(alias)')
    	));
    }
    
    public function getTabSettings()
    {
    	return array(
    		array('handleLabel' => '基本信息', 'content' => array('label', 'fulltext', 'appendImage', 'alias')),
    	);
    }
}