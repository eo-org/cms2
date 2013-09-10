<?php

namespace Twig\View;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\View\ViewEvent;
use Twig\View\Renderer;

class Strategy implements ListenerAggregateInterface
{
	
    protected $listeners = array();

    protected $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function attach(EventManagerInterface $events, $priority = 100)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, array($this, 'selectRenderer'), $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, array($this, 'injectResponse'), $priority);
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

    public function selectRenderer(ViewEvent $e)
    {
        if ($this->renderer->canRender($e->getModel()->getTemplate())) {
            return $this->renderer;
        }
        return false;
    }

    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->renderer) {
            return;
        }
        $result   = $e->getResult();
        $response = $e->getResponse();

        $response->setContent($result);
    }
}