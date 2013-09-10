<?php
namespace Twig;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\StaticEventManager;

class Module
{
	public function init($moduleManager)
	{
		$sharedEvents = StaticEventManager::getInstance();
		$sharedEvents->attach('Zend\Mvc\Application', 'dispatch', array($this, 'setTwig'), 100);
	}
	
	public function setTwig(MvcEvent $event)
	{
		
	}
	
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/Twig',
				)
			)
		);
	}
}