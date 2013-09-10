<?php
namespace Application;

use Zend\I18n\Translator\Translator;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Application;
use Zend\EventManager\StaticEventManager;
use Cms\Session\Admin as SessionAdmin;
use Cms\Twig\View\Renderer as TwigViewRenderer;
use Cms\Twig\View\Resolver as TwigViewResolver;
use Cms\Twig\View\Strategy as TwigViewStrategy;

class Module
{
	public function init($moduleManager)
	{
		$sharedEvents = StaticEventManager::getInstance();
		
		$sharedEvents->attach('Cms\ApplicationController', 'dispatch', array($this, 'setTwig'), 100);
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
	
	public function setTwig(MvcEvent $e)
	{
		$application	= $e->getApplication();
		$sm				= $application->getServiceManager();
		$twigEnv		= $sm->get('Twig\Environment');
		
		$config = $sm->get('Config');
		$twigConfig = $config['twig'];
		foreach($twigConfig['filters'] as $filterName) {
			$twigEnv->addFilter($filterName, new \Twig_Filter_Function('Cms\Twig\Filter::'.$filterName));
		}
		foreach($twigConfig['functions'] as $functionName => $func) {
			$twigEnv->addFunction(new \Twig_SimpleFunction($functionName, $func, array('is_safe' => array('html'))));
		}
		
		$siteConfig = $sm->get('ConfigObject\EnvironmentConfig');
		$twigEnv->addFunction(new \Twig_SimpleFunction(
			'siteConfig',
			function($type) use ($siteConfig) {
				return $siteConfig->{$type};
			},
			array('is_safe' => array('html'))
		));
		
		$resolver = new TwigViewResolver($twigEnv);
		$renderer = new TwigViewRenderer($twigEnv, $resolver);
		$renderer->setHelperPluginManager($sm->get('ViewHelperManager'));
		$twigStrategy = new TwigViewStrategy($renderer);
		
		$view = $sm->get('Zend\View\View');
		$view->getEventManager()->attach($twigStrategy, 1);
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