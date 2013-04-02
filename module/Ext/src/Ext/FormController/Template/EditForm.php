<?php
namespace Ext\FormController\Template;

use Zend\Form\Form;

class EditForm extends Form
{
    public function __construct()
    {
    	parent::__construct('template-edit');
    	
    	$this->add(array(
        	'name' => 'scriptName',
        	'attributes' => array('type' => 'text'),
        	'options' => array('label' => 'Template文件名')
        ));
    	$this->add(array(
    		'name' => 'content',
    		'attributes' => array('type' => 'textarea', 'id' => 'codemirror-editor'),
    		'options' => array('label' => 'Template文件内容')
    	));
    	$this->add(array(
    		'name' => 'extName',
    		'attributes' => array('type' => 'hidden'),
    	));
    }
}