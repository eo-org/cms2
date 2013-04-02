<?php
namespace Cms;

use Zend\Mvc\MvcEvent;

use Zend\Stdlib\DispatchableInterface, Zend\Stdlib\RequestInterface as Request, Zend\Stdlib\ResponseInterface as Response;
use Zend\Mvc\InjectApplicationEventInterface, Zend\EventManager\EventInterface as Event;
use Zend\ServiceManager\ServiceLocatorAwareInterface, Zend\ServiceManager\ServiceLocatorInterface;
use Zend\I18n\Translator\Translator;
use Zend\EventManager\StaticEventManager, Zend\EventManager\EventManager;
use Fucms\Session\Admin as SessionAdmin;

class ApplicationController implements
	DispatchableInterface,
    InjectApplicationEventInterface,
    ServiceLocatorAwareInterface
{
	/**
	 * 
	 * @var \Zend\EventManager\EventManager
	 */
	protected $events;
	
	/**
	 * 
	 * @var \Zend\Mvc\MvcEvent
	 */
	protected $mvcEvent;
	
	/**
	 * 
	 * @var \Zend\ServiceManager\ServiceManager
	 */
	protected $serviceManager;
	
	public function dispatch(Request $request, Response $response = null)
	{
		$lcm = $request->getQuery('local-css-mode');
		if($lcm == 'activate') {
			$sessionAdmin = new SessionAdmin();
			$sessionAdmin->setUserData('localCssMode', true);
		} else if($lcm == 'deactivate') {
			$sessionAdmin = new SessionAdmin();
			$sessionAdmin->setUserData('localCssMode', false);
		}
		
		$this->getEvent()->setTarget($this);
		
		$layoutFront = $this->serviceManager->get('Cms\Layout\Front');
		$viewModel = $layoutFront->initActionController($this);
		
		$sm = $this->getServiceLocator();
	
		$factory = $sm->get('Core\Mongo\Factory');
		$co = $factory->_m('Info');
		$infoDoc = $co->fetchOne();
	
		$locale = 'zh_CN';
		if(!is_null($infoDoc)) {
			$locale = $infoDoc->language;
		}
		$translator = Translator::factory(array(
			'locale' => $locale,
			'translation_file_patterns' => array(
				array(
					'type'			=> 'gettext',
					'base_dir'		=> __DIR__ . '/../../language',
					'pattern'		=> '%s.mo',
				)
			)
		));
		$sm->setService('translator', $translator);
		
		$viewModel->setVariables(array(
			'layoutDoc' => $layoutFront->getLayoutDoc(),
			'stageList' => $layoutFront->getStageList(),
			'brickViewList' => $layoutFront->getBrickViewList(),
		));
		
		$this->getEventManager()->trigger(MvcEvent::EVENT_DISPATCH, $this->getEvent());
	}
	
	public function layout($template = null)
	{
		$viewModel = $this->getEvent()->getViewModel();
		if(null !== $template) {
			$viewModel->setTemplate((string) $template);
		}
		return $viewModel;
	}
	
	public function setEvent(Event $event)
	{
		$this->mvcEvent = $event;
	}
	
    public function getEvent()
    {
    	return $this->mvcEvent;
    }
    
    public function setServiceLocator(ServiceLocatorInterface $serviceManager)
    {
    	$this->serviceManager = $serviceManager;
    }
    
    public function getServiceLocator()
    {
    	return $this->serviceManager;
    }
    
    public function getEventManager()
    {
    	if(!$this->events) {
    		$this->setEventManager(new EventManager('Cms\ApplicationController'));
    	}
    	return $this->events;
    }
    
    public function setEventManager(EventManager $events)
    {
    	$this->events = $events;
    }
}