<?php
namespace User;

use Cms\Layout\ContextAbstract;

class Context extends ContextAbstract
{
	protected $type;
	
	public function init()
	{
		$layoutCo = $this->dbFactory->_m('Layout');
		
		$layoutDoc = $layoutCo->addFilter('type', 'user')
			->addFilter('default', 1)
			->fetchOne();
		if($layoutDoc == null) {
			$layoutDoc = $this->createDefaultLayout('user');
		}
		
		$this->layoutDoc = $layoutDoc;
	}
	
	public function getBreadcrumb()
	{
		return null;
	}
	
	public function getResourceId()
	{
		return $this->layoutDoc->getId();
	}
	
	public function getTitle()
	{
		return $this->layoutDoc->label;
	}
	
	public function getType()
	{
		return "user";
	}
}