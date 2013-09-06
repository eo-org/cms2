<?php
namespace User\Form;

use Zend\Form\Form;

class ChangePasswordForm extends Form
{
    public function __construct()
    {
    	parent::__construct('user-change-password');
    	
    	$this->add(array(
    		'name' => 'password',
    		'attributes' => array('type' => 'password'),
    		'options' => array('label' => '新密码')
    	));
    	$this->add(array(
    		'name' => 'password_2',
    		'attributes' => array('type' => 'password'),
    		'options' => array('label' => '再次输入密码')
    	));
    	$this->add(array(
    		'name' => 'login-button',
    		'attributes' => array('type' => 'button', 'id' => 'form-submit-button'),
    		'options' => array('label' => '')
    	));
    }
}