<?php
namespace Cms\Layout\Context;

use MongoId;
use Cms\Layout\ContextAbstract;

class ArticleList extends ContextAbstract
{
	protected $shouldCache = true;
	
	protected $groupItemId;
	protected $routeParams = array();
	protected $groupItemDoc;
	protected $groupDoc;
	protected $trail = array();
	
	protected $groupLabel;
	
	public function init($id, $presetLayoutDoc = null)
	{
		$groupItemCo = $this->dbFactory->_m('Group_Item');
		$groupItemDoc = $groupItemCo->addFilter('$or', array(
				array('_id' => new MongoId($id)),
				array('alias' => $id)
			))->fetchOne();
		if($groupItemDoc == null) {
			$groupItemId = 0;
		} else {
			$groupItemId = $groupItemDoc->getId();
			$this->groupLabel = $groupItemDoc->label;
		}
		$groupCo = $this->dbFactory->_m('Group');
		$groupDoc = $groupCo->findArticleGroup();
		$this->groupItemId = $groupItemId;
		$this->groupItemDoc = $groupItemDoc;
		$this->groupDoc = $groupDoc;
		$this->trail = $groupDoc->getTrail($groupItemId);
		
		$layoutAlias = null;
		foreach($this->trail as $seek) {
			if(isset( $seek['layoutAlias'])) {
				$layoutAlias = $seek['layoutAlias'];
			}
		}
		$this->contextId = $layoutAlias;
		
		$layoutDoc = null;
		if(is_null($presetLayoutDoc)) {
			$layoutCo = $this->dbFactory->_m('Layout');
			if($layoutAlias != null) {
				//try to load by alias;
				$layoutDoc = $layoutCo->addFilter('type', 'list')
					->addFilter('alias', $layoutAlias)
					->fetchOne();
			}
			if($layoutDoc == null) {
				//load default
				$layoutDoc = $layoutCo->addFilter('type', 'list')
					->addFilter('default', 1)
					->fetchOne();
			}
			if($layoutDoc == null) {
				//create and load default
				$layoutDoc = $this->createDefaultLayout('list');
			}
		} else {
			$layoutDoc = $presetLayoutDoc;
		}
		
		$this->layoutDoc = $layoutDoc;
		$this->routeParams = array('id' => $id);
	}
	
	public function getRouteParams()
	{
		return $this->routeParams;
	}
	
	public function getGroupItemId()
	{
		return $this->groupItemId;
	}
	
	public function getGroupItemDoc()
	{
		return $this->groupItemDoc;
	}
	
	public function getGroupDoc()
	{
		return $this->groupDoc;
	}
	
	public function getBreadcrumb()
	{
		if($this->breadcrumb == null) {
			foreach($this->trail as $step) {
				if(empty($step['alias'])) {
					$url = "/list-".$step['id'].'/page1.shtml';
				} else {
					$url = "/list-".$step['alias'].'/page1.shtml';
				}
				
				$this->breadcrumb[] = array(
					'url' => $url,
					'label' => $step['label']
				);
			}
		}
		
		return $this->breadcrumb;
	}
	
	public function getResourceId()
	{
		return $this->groupItemId;
	}
	
	public function getTitle()
	{
		return $this->groupLabel;
	}
	
	public function getType()
	{
		return "article-list";
	}
}