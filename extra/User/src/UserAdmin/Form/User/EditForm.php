<?php
namespace UserAdmin\Form\User;

use Zend\Form\Form;

class EditForm extends Form
{
    public function __construct()
    {
    	parent::__construct('user-edit');
    	
    	$this->add(array(
    		'name' => 'userGroup',
    		'type' => 'Zend\Form\Element\Select',
    		'options' => array('label' => '用户类型', 'value_options' => array(
    			'online' => '网络注册用户',
    			'verified' => '认证用户',
    		))
    	));
    	$this->add(array(
    		'name' => 'status',
    		'type' => 'Zend\Form\Element\Select',
    		'options' => array('label' => '用户状态', 'value_options' => array(
    			'active' => '激活',
    			'inactive' => '冻结'
    		))
    	));
    }
}