<?php
namespace Admin\Form\System;

use Zend\Form\Form;

class OrgnizationForm extends Form
{
	public function __construct()
    {
    	parent::__construct('orgnization-edit');
    	
    	$this->add(array(
    		'name' => 'organizationCode',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => 'ORG OWNER ID')
    	));
    }
    
    public function getTabSettings()
    {
    	return array(
    		array('handleLabel' => '基本信息', 'content' => array('organizationCode')),
    	);
    }
}