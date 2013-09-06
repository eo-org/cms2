<?php
namespace User\Form;

use Zend\Form\Form;

class RegisterForm extends Form
{
    public function __construct()
    {
    	parent::__construct('user-register');
    	$this->setAttribute('action', '/user/register');
    	
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
    		'name' => 'password_2',
    		'attributes' => array('type' => 'password'),
    		'options' => array('label' => '再次输入密码')
    	));
    	$this->add(array(
    		'name' => 'register-button',
    		'attributes' => array('type' => 'button', 'id' => 'form-submit-button'),
    		'options' => array('label' => '')
    	));
    }
}