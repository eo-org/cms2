<?php
namespace Application;

use Zend\I18n\Translator\Translator;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Application;
use Zend\EventManager\StaticEventManager;
use Fucms\Session\Admin as SessionAdmin;

class Module
{
	public function init($moduleManager)
	{
		$sharedEvents = StaticEventManager::getInstance();
		$sharedEvents->attach('Zend\Mvc\Application', 'dispatch.error', array($this, 'onError'), 100);
		
		$sessionAdmin = new SessionAdmin();
		if(!$sessionAdmin->isLogin()) {
			$listener = new \Cms\Cache\Listener\CacheListener();
			$sharedEvents->attach('Zend\Mvc\Application', $listener, null);
		}
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
					__NAMESPACE__ => __DIR__ . '/src/Application',
				)
			)
		);
	}
	
	public function onError(MvcEvent $e)
	{
		$target = $e->getTarget();
		if($target instanceof Application) {
			echo "handled in onError Event<br />";
			echo $e->getError();
			echo "<br />";
			die('END');
		} else {
			$target->layout('layout/error');
		}
	}
}