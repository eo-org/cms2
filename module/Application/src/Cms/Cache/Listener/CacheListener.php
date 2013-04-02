<?php
namespace Cms\Cache\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

use Zend\Cache\StorageFactory;
use Cms\Cache\Manager as CacheManager;
use Cms\Cache\Storage\Adapter\MongoOptions;

class CacheListener implements ListenerAggregateInterface
{
    protected $listeners = array();
    protected $cacheManager;

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('route', array($this, 'onRoute'), -100);
        $this->listeners[] = $events->attach('finish', array($this, 'onFinish'), -100);
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * Load the page contents from the cache and set the response.
     *
     * @param  \Zend\Mvc\MvcEvent             $e
     * @return \Zend\Stdlib\ResponseInterface
     */
    public function onRoute(MvcEvent $e)
    {
    	$sm = $e->getApplication()->getServiceManager();
    	$context = $sm->get('Cms\Layout\Front')->getContext();
    	$storage = StorageFactory::factory(array(
    		'adapter' => 'Cms\Cache\Storage\Adapter\Mongo',
    		'options' => new MongoOptions()
    	));
    	$dm = $sm->get('DocumentManager');
    	$storage->setDocumentManager($dm);
    	
    	$this->cacheManager = new CacheManager($storage, $context);
    	
    	$cacheContent = $this->cacheManager->load();
    	if(is_null($cacheContent)) {
    		return;
    	} else {
	    	$response = $e->getResponse();
	    	$response->setContent($cacheContent);
	    	
	    	return $response;
    	}
    }

    /**
     * Save page contents to the cache
     *
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onFinish(MvcEvent $e)
    {
    	$response = $e->getResponse();
    	$this->cacheManager->save($response);
    }
}
