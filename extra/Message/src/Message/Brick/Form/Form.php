<?php
namespace Message\Brick\Form;

use Zend\Form\Fieldset;

class Form extends Fieldset
{
	public function __construct($dm)
	{
		parent::__construct('params');
		
		$qb = $dm->createQueryBuilder('Message\Document\MessageForm');
		$cursor = $qb->sort('_id', -1)
			->select('id', 'label')
			->getQuery()
			->execute();
		
		$options = array();
		foreach($cursor as $data) {
			$options[$data->getId()] = $data->getLabel();
		}
		
    	$this->add(array(
    		'name' => 'messageFormId',
    		'type' => 'Zend\Form\Element\Select',
    		'options' => array(
    			'label' => '选择表单',
    			'value_options' => $options
    		)
    	));
	}
}