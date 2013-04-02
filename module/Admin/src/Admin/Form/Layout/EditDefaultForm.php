<?php
namespace Admin\Form\Layout;

use Zend\Form\Form;

class EditDefaultForm extends Form
{
    public function __construct()
    {
    	parent::__construct('layout-edit-default');
    	
    	$this->add(array(
    		'name' => 'useTpl',
    		'type' => 'Zend\Form\Element\Checkbox',
    		'options' => array('label' => '使用TPL')
    	));
    	$this->add(array(
    		'name' => 'tplFileContent',
    		'attributes' => array('type' => 'textarea', 'id' => 'codemirror-editor'),
    		'options' => array('label' => 'TPL文件内容')
    	));
    }
}