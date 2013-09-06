<?php
namespace Message;

//use Zend\Mvc\MvcEvent;
use Zend\EventManager\StaticEventManager;
//use Zend\Serializer\Adapter\Json;

class Module
{
	public function init($moduleManager)
	{
		$sharedEvents = StaticEventManager::getInstance();
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
					'Message'		=> __DIR__ . '/src/Message',
					'MessageAdmin'	=> __DIR__ . '/src/MessageAdmin',
					'MessageRest'	=> __DIR__ . '/src/MessageRest'
				)
			)
		);
	}
	
	/*
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
	*/
}
