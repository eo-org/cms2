<?php
namespace Admin;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\ModuleEvent;
use Zend\EventManager\StaticEventManager;
use Zend\Session\Container;
use Core\Session\SsoAuth;
use Fucms\Session\Admin as SessionAdmin;
use Fucms\Brick\Register;
use Fucms\Brick\Service\RegisterConfigAdmin;

class Module
{
	public function init($moduleManager)
	{
		$sharedEvents = StaticEventManager::getInstance();
		$sharedEvents->attach('Zend\Mvc\Application', 'dispatch', array($this, 'userAuth'), 10);
		$sharedEvents->attach('Zend\Mvc\Application', 'dispatch', array($this, 'setLayout'), -100);
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
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
				),
            ),
        );
    }
    
	public function userAuth(MvcEvent $e)
	{
		$rm = $e->getRouteMatch();
		$matchedRouteName = $rm->getMatchedRouteName();
		if(substr($matchedRouteName, 0, 5) == 'admin') {
			$sm = $e->getApplication()->getServiceManager();
			$siteConfig = $sm->get('ConfigObject\EnvironmentConfig');
			$orgCode = $siteConfig->organizationCode;
			
			$sessionAdmin = new SessionAdmin();
			$sessionAdmin->setOrgCode($orgCode);
			$ssoAuth = new SsoAuth($sessionAdmin);
			$ssoAuth->auth();
		}
	}
	
	public function setLayout(MvcEvent $e)
	{
		$rm = $e->getRouteMatch();
		$matchedRouteName = $rm->getMatchedRouteName();
		$matchedRouteNameParts = explode('/', $matchedRouteName);
		if($matchedRouteNameParts[0] == 'admin') {
			$disableLayout = false;
			$controller = $e->getTarget();
			$controllerName = $controller->params()->fromRoute('controller');
			$format = $controller->params()->fromRoute('format');
			if($format == 'ajax') {
				$controller->layout('layout-admin/ajax');
			} else if($format == 'bone') {
				$controller->layout('layout-admin/bone');
				$disableLayout = true;
			} else {
				$controller->layout('layout-admin/layout');
			}
			
			if(!$disableLayout) {
				$routeMatch = $e->getRouteMatch();
				$brickRegister = new Register($controller, new RegisterConfigAdmin());
				$jsList = $brickRegister->getJsList();
				$cssList = $brickRegister->getCssList();
				$brickViewList = $brickRegister->renderAll();
				
				$config = $e->getApplication()->getServiceManager()->get('Config');
				$siteConfig = $e->getApplication()->getServiceManager()->get('ConfigObject\EnvironmentConfig');
				
				$viewModel = $e->getViewModel();
				$viewModel->setVariables(array(
						'routeMatch'	=> $routeMatch,
						'brickViewList'	=> $brickViewList,
						'jsList'		=> $jsList,
						'cssList'		=> $cssList,
						'toolbar'		=> $config['admin_toolbar'],
						'remoteSiteId'	=> $siteConfig->remoteSiteId,
				));
			}
		}
	}
}