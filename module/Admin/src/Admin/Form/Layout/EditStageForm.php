<?php
namespace Admin\Form\Layout;

use Zend\Form\Form;

class EditStageForm extends Form
{
    public function __construct()
    {
		parent::__construct('layout-stage-edit');
		
		$this->add(array(
    		'name' => 'uniqueId',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => 'STAGE ID')
    	));
		$this->add(array(
			'name' => 'isViewContentHolder',
			'type' => 'Zend\Form\Element\Select',
			'options' => array('label' => 'VIEW CONTENT', 'value_options' => array(
				'no' => '否',
				'yes' => '是',
			))
		));
	}
}