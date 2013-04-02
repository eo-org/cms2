<?php
namespace User\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct()
    {
    	parent::__construct('user-login');
    	$this->setAttribute('action', '/user/login');
    	
    	$this->add(array(
    		'name' => 'email',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => '邮箱')
    	));
    	$this->add(array(
    		'name' => 'password',
    		'attributes' => array('type' => 'password'),
    		'options' => array('label' => '密码')
    	));
    	$this->add(array(
    		'name' => 'login-button',
    		'attributes' => array('type' => 'button', 'id' => 'form-submit-button'),
    		'options' => array('label' => '')
    	));
    }
}