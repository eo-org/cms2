<?php
namespace MessageAdmin\Form;

use Zend\Form\Form;

class MessageForm extends Form
{
	public $tabSettings = array(
    	array('label', 'description', 'confirmationText')
    );
	
    public function __construct()
    {
    	parent::__construct('messageform-edit');
    	
    	$this->add(array(
    		'name' => 'label',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => '表单名')
    	));
    	$this->add(array(
    		'name' => 'description',
    		'attributes' => array('type' => 'textarea'),
    		'options' => array('label' => '介绍')
    	));
    	$this->add(array(
    		'name' => 'confirmationText',
    		'attributes' => array('type' => 'textarea'),
    		'options' => array('label' => '确认文字')
    	));
    }
    
    public function getTabSettings()
    {
    	return array(
			array('handleLabel' => '基本信息', 'content' => $this->tabSettings[0])
    	);
    }
}