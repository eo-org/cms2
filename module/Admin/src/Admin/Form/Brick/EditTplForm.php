<?php
namespace Admin\Form\Brick;

use Zend\Form\Form;

class EditTplForm extends Form
{
    public function __construct()
    {
    	parent::__construct('brick-edit-tpl');
    	
    	$this->add(array(
        	'name' => 'tplFileName',
        	'attributes' => array('type' => 'text'),
        	'options' => array('label' => 'TPL文件名')
        ));
    	$this->add(array(
    		'name' => 'tplFileContent',
    		'attributes' => array('type' => 'textarea', 'id' => 'codemirror-editor'),
    		'options' => array('label' => 'TPL文件内容')
    	));
    }
}