<?php
namespace Ext\Service;

use Zend\Mvc\MvcEvent;
use Ext\Service\Register;

class RegisterConfig
{
	protected $layoutDoc;
	protected $controller;
	protected $sm;

	public function __construct($layoutDoc, $controller)
	{
		$this->layoutDoc = $layoutDoc;
		$this->controller = $controller;
		$this->sm = $controller->getServiceLocator();
	}

	public function configRegister(Register $register)
	{
		$layoutDoc = $this->layoutDoc;
		$layoutId = $layoutDoc->getId();
		$factory = $this->sm->get('Core\Mongo\Factory');
		$co = $factory->_m('Brick');
			
		if($layoutDoc->hideHead == "1" && $layoutDoc->HideTail == "1") {
			$co->addFilter('layoutId', $layoutId)
			->addFilter('active', 1)
			->sort('sort');
		} else {
			$co->addFilter('$or', array(
					array('layoutId' => $layoutId),
					array('layoutId' => '0'))
			)
			->addFilter('active', 1)
			->sort('sort');
		}
		$brickDocs = $co->fetchDoc();

		foreach($brickDocs as $brick) {
			$register->registerBrick($brick);
		}
	}
}