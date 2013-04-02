<?php
namespace Admin\Form\Brick;

use Zend\Form\Form;

class EditForm extends Form
{
    public function __construct()
    {
    	parent::__construct('brick-edit');
    	
    	$this->add(array(
    		'name' => 'brickName',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => '模块名')
        ));
        $this->add(array(
        	'name' => 'displayBrickName',
        	'type' => 'Zend\Form\Element\Select',
        	'options' => array(
        		'label' => '模块名',
        		'value_options' => array(
	        		0 => '不显示',
	        		1 => '显示标题',
	        		2 => '仅显示DIV'
				)
			)
        ));
        $this->add(array(
        	'name' => 'sort',
        	'attributes' => array('type' => 'text'),
        	'options' => array('label' => '模块排序')
        ));
        $this->add(array(
        	'name' => 'cssSuffix',
        	'attributes' => array('type' => 'text'),
        	'options' => array('label' => 'CSS后缀')
        ));
        $this->add(array(
        	'name' => 'tplName',
        	'type' => 'Zend\Form\Element\Select',
        	'options' => array('label' => 'TPL文件')
        ));
        
        $this->add(array(
    		'name' => 'extName',
    		'attributes' => array('type' => 'hidden')
    	));
        $this->add(array(
        	'name' => 'layoutId',
        	'attributes' => array('type' => 'hidden')
        ));
        $this->add(array(
        	'name' => 'stageId',
            'attributes' => array('type' => 'hidden')
        ));
        $this->add(array(
        	'name' => 'spriteName',
            'attributes' => array('type' => 'hidden')
        ));
    }
}