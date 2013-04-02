<?php
namespace Admin\Form\Book;

use Zend\Form\Form;

class EditForm extends Form
{
    public function __construct()
    {
    	parent::__construct('book-edit');
    	
    	$this->add(array(
    		'name' => 'label',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => '手册名')
    	));
    	$this->add(array(
    		'name' => 'alias',
    		'attributes' => array(
    			'type' => 'text',
    			'description' => '通过别名地址 "/{alias}.shtml" 或者 "/{alias}" 访问手册'
    		),
    		'options' => array('label' => '手册别名(alias)')
    	));
    	$this->add(array(
    		'name' => 'layoutAlias',
    		'attributes' => array(
    			'type' => 'text'
    		),
    		'options' => array('label' => 'LAYOUT别名(alias)')
    	));
    }
    
    public function getTabSettings()
    {
    	return array(
    		array('handleLabel' => '基本信息', 'content' => array('label', 'alias', 'layoutAlias')),
    	);
    }
}