<?php
namespace Ext\Form\Product;

use Zend\Form\Fieldset;
use Core\Func;

class Selector extends Fieldset
{
	public function __construct($factory)
	{
		parent::__construct('params');
		
    	$options = Func::getNumericArray(4, 16);
    	$this->add(array(
    		'name' => 'filters',
    		'type' => 'Zend\Form\Element\Textarea',
    		'options' => array(
    			'label' => 'Selector Param',
    		)
    	));
	}
}