<?php
namespace Ext\Form\Player;

use Zend\Form\Fieldset;

class Player extends Fieldset
{
	public function __construct($factory)
	{
		parent::__construct('params');
    	
    	$this->add(array(
    		'name' => 'fileurl',
    		'type' => 'Zend\Form\Element\Text',
    		'options' => array(
    			'label' => '媒体文件url'
    		)
    	));
	}
}