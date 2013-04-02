<?php
namespace Disqus;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\StaticEventManager;
use Zend\Serializer\Adapter\Json;

use Fucms\Brick\Register, Fucms\Brick\Service\RegisterConfigAdmin;

class Module
{
	public function init($moduleManager)
	{
		$sharedEvents = StaticEventManager::getInstance();
		//$sharedEvents->attach('Disqus', 'dispatch', array($this, 'setFrontLayout'), -10);
		//$sharedEvents->attach('DisqusAdmin', 'dispatch', array($this, 'setAdminLayout'), -100);
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
					'Disqus'		=> __DIR__ . '/src/Disqus',
					'DisqusAdmin'	=> __DIR__ . '/src/DisqusAdmin',
					'DisqusRest'	=> __DIR__ . '/src/DisqusRest'
				)
			)
		);
	}
	
	public function setTranslator(MvcEvent $e)
	{
		$controller = $e->getTarget();
		$sm = $controller->getServiceLocator();
		
		$factory = $controller->dbFactory();
		$co = $factory->_m('Info');
		$this->infoDoc = $co->fetchOne();
		
		$locale = 'zh_CN';
		if(!is_null($this->infoDoc)) {
			$locale = $this->infoDoc->language;
		}
		$translator = Translator::factory(array(
			'locale' => $locale,
			'translation_file_patterns' => array(
				array(
					'type'			=> 'gettext',
					'base_dir'		=> __DIR__ . '/language',
					'pattern'		=> '%s.mo',
				)
			)
		));
		$sm->setService('translator', $translator);
	}
	
	public function setFrontLayout(MvcEvent $e)
	{
		$rm = $e->getRouteMatch();
		
		echo $rm->getMatchedRouteName();
		
		if($e->getRequest()->isXmlHttpRequest()) {
			$jsonArr = $e->getResult();
			$response = $e->getResponse();
			$response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
			$adapter = new Json();
			$response->setContent($adapter->serialize($jsonArr));
			return $response;
		} else {
			die('not-available with http request');
		}
	}
}
