<?php
namespace Rest;

use Zend\EventManager\StaticEventManager;
use Zend\Mvc\MvcEvent;
use Zend\Serializer\Adapter\Json;

class Module
{
	public function init()
	{
		$sharedEvents = StaticEventManager::getInstance();
//		$sharedEvents->attach(__NAMESPACE__, 'dispatch', array($this, 'returnJson'), -10);
	}
	
	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function returnJson(MvcEvent $e)
	{
		$rm = $e->getRouteMatch();
		$rName = $rm->getMatchedRouteName();
		echo $rName.' : ';
		echo $rm->getParam('format');
		die();
	}
}