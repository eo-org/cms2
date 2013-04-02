<?php
namespace UserAdmin\Form\Index;

use Zend\Form\Form;

class ConfigForm extends Form
{
    public function __construct()
    {
    	parent::__construct('user-config');
    	
    	$this->add(array(
    		'name' => 'acl',
    		'type' => 'Zend\Form\Element\Select',
    		'options' => array('label' => '内容权限管理', 'value_options' => array(
    			'disable' => '不启用',
    			'enable' => '启用',
    		))
    	));
    	
    	$this->add(array(
    		'name' => 'protectedResourceId',
    		'type' => 'Zend\Form\Element\MultiCheckbox',
    		'options' => array('label' => '认证用户访问资源')
    	));
    }
}