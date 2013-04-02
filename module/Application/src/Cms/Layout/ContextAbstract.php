<?php
namespace Cms\Layout;

use Exception;
use MongoId;

abstract class ContextAbstract
{
	protected $dbFactory;
	protected $layoutDoc;
	protected $trail;
	protected $breadcrumb;
	protected $contextId = null;
	protected $params = array();
	protected $query = array();
	protected $shouldCache = false;
	
	public function __construct($dbFactory)
	{
		$this->dbFactory = $dbFactory;
	}
	
	protected function createDefaultLayout($type)
	{
		$layoutCo= $this->dbFactory->_m('Layout');
		
		$layoutDoc = $layoutCo->create();
		$layoutDoc->type = $type;
		$layoutDoc->default = 1;
		$layoutDoc->save();
		
		return $layoutDoc;
	}
	
	public function getLayoutDoc()
	{
		return $this->layoutDoc;
	}
	
	public function getContextId()
	{
		return $this->contextId;
	}
	
	public function getTrail()
	{
		return $this->trail;
	}
	
	public function getResourceDoc()
	{
		return null;
	}
	
	public function setQuery($query)
	{
		$this->query = $query;
		return $this;
	}
	
	public function getQuery()
	{
		return $this->query;
	}
	
	public function setParams($params)
	{
		$this->params = $params;
		return $this;
	}
	
	public function getParams()
	{
		return $this->params;
	}
	
	public function getParam($key, $default = null)
	{
		if(array_key_exists($key, $this->params)) {
			return $this->params[$key];
		}
		return $default;
	}
	
	public function shouldCache()
	{
		return $this->shouldCache;
	}
	
	abstract public function getResourceId();
	
	abstract public function getTitle();
	
	abstract public function getType();
}