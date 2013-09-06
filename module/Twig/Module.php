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
		$application = $event->getApplication();
		$sm = $application->getServiceManager();
		$config = $sm->get('Config');
		
		$twigConfig = $config['twig'];
		
		$twigEnv = View::getTwigEnv();
		$twigEnv->addFilter('outputImage',		new \Twig_Filter_Function('Twig\Filter::outputImage'));
		$twigEnv->addFilter('graphicDataJson',	new \Twig_Filter_Function('Twig\Filter::graphicDataJson'));
		$twigEnv->addFilter('substr',			new \Twig_Filter_Function('Twig\Filter::substr'));
		$twigEnv->addFilter('url',				new \Twig_Filter_Function('Twig\Filter::url'));
		$twigEnv->addFilter('pageLink',			new \Twig_Filter_Function('Twig\Filter::pageLink'));
		$twigEnv->addFilter('translate',		new \Twig_Filter_Function('Twig\Filter::translate'));
		$twigEnv->addFilter('query',			new \Twig_Filter_Function('Twig\Filter::query'));
	
		$twigEnv->addFunction(new \Twig_SimpleFunction('getArrayValue', function($arr, $key, $default = null) {
			if(isset($arr[$key])) {
				return $arr[$key];
			}
			return $default;
		}));
		
		foreach($twigConfig['functions'] as $functionName => $func) {
			$twigEnv->addFunction(new \Twig_SimpleFunction($functionName, $func));
		}
		
		$templateDir = array();
		$brickPathStackConfig = $config['brick_path_stack'];
		$fileLoader = new \Twig_Loader_Filesystem($brickPathStackConfig);
		View::setFileLoader($fileLoader);

		$dm = $sm->get('DocumentManager');
		$loader = new DatabaseLoader($dm, $fileLoader);

		$twigEnv->setLoader($loader);
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