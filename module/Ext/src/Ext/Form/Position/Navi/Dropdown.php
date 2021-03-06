<?php
namespace Ext\Form\Position\Navi;

use Zend\Form\Fieldset;

class Dropdown extends Fieldset
{
	public function __construct($factory)
	{
		parent::__construct('params');
    	
    	$co = $factory->_m('Navi');
    	$docArr = $co->setFields('label')->fetchArr('label');
    	$this->add(array(
    		'name' => 'naviId',
    		'type' => 'Zend\Form\Element\Select',
    		'options' => array(
    			'label' => '选择目录组',
    			'value_options' => $docArr
    		)
    	));
	}
}