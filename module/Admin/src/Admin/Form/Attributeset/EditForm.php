<?php
namespace Admin\Form\Attributeset;

use Zend\Form\Form;

class EditForm extends Form
{
    public function __construct()
    {
    	parent::__construct('attributeset-create');
    	
    	$this->add(array(
    		'name' => 'label',
    		'attributes' => array('type' => 'text'),
    		'options' => array(
    			'label' => '产品分类名'
    		)
    	));
    	$this->add(array(
    		'name' => 'type',
    		'attributes' => array('type' => 'hidden', 'value' => 'product')
    	));
    }
    
    public function getTabSettings()
    {
    	return array(
    		array('handleLabel' => '基本信息', 'content' => array('label', 'type')),
    	);
    }
}