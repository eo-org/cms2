<?php
namespace Location;

use Zend\Mvc\MvcEvent, Zend\EventManager\StaticEventManager;

class Module
{
	public function init($moduleManager)
	{
		$sharedEvents = StaticEventManager::getInstance();
// 		$listener = new \User\Acl\Listener\AclListener();
// 		$sharedEvents->attach('Zend\Mvc\Application', $listener, null);
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
					'Location'		=> __DIR__ . '/src/Location',
					'LocationAdmin'	=> __DIR__ . '/src/LocationAdmin',
					'LocationRest'	=> __DIR__ . '/src/LocationRest'
				)
            ),
        );
    }
}