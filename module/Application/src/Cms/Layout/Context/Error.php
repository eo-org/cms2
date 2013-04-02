<?php
namespace Cms\Layout\Context;

use Cms\Layout\ContextAbstract;

class Error extends ContextAbstract
{
	protected $shouldCache = true;
	
	public function init($id)
	{
		$layoutCo = $this->dbFactory->_m('Layout');
		
		$layoutDoc = $layoutCo->addFilter('type', 'error')
			->addFilter('alias', $id)
			->fetchOne();
		if($layoutDoc == null) {
			$layoutDoc = $this->createAliasLayout($id);
		}
		
		$this->layoutDoc = $layoutDoc;
	}
	
	protected function createAliasLayout($code)
	{
		$layoutCo= $this->dbFactory->_m('Layout');
		
		$layoutDoc = $layoutCo->create();
		$layoutDoc->type = 'error';
		$layoutDoc->alias = $code;
		$layoutDoc->label = "page not available ".$code;
		$layoutDoc->save();
		
		return $layoutDoc;
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
		return "error";
	}
}