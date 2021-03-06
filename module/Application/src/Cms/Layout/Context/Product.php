<?php
namespace Cms\Layout\Context;

use Cms\Layout\ContextAbstract;

class Product extends ContextAbstract
{
	protected $shouldCache = true;
	
	protected $groupItemId;
	protected $groupAlias;
	protected $groupDoc;
	protected $trail = array();
	
	protected $productDoc;
	protected $productId;
	protected $productLabel;
	
	public function init($id)
	{
		$productCo = $this->dbFactory->_m('Product');
		$productDoc = $productCo->find($id);
		if($productDoc == null) {
			$this->groupItemId = 0;
		} else {
			$this->productDoc = $productDoc;
			$this->groupItemId = $productDoc->groupId;
			$this->productLabel = $productDoc->label;
		}
		$groupCo = $this->dbFactory->_m('Group');
		$groupDoc = $groupCo->findProductGroup();
		$this->groupDoc = $groupDoc;
		$this->trail = $groupDoc->getTrail($this->groupItemId);
		
		$layoutCo = $this->dbFactory->_m('Layout');
		$layoutDoc = $layoutCo->addFilter('type', 'product')
			->fetchOne();
		if($layoutDoc == null) {
			$layoutDoc = $this->createDefaultLayout('product');
		}
		$this->layoutDoc = $layoutDoc;
	}
	
	public function getResourceDoc()
	{
		return $this->productDoc;
	}
	
	public function getGroupDoc()
	{
		return $this->groupDoc;
	}
	
	public function getGroupItemId()
	{
		return $this->groupItemId;
	}
	
	public function getBreadcrumb()
	{
		if($this->breadcrumb == null) {
			foreach($this->trail as $step) {
				if(empty($step['alias'])) {
					$url = "/product-list-".$step['id'].'/page1.shtml';
				} else {
					$url = "/product-list-".$step['alias'].'/page1.shtml';
				}
	
				$this->breadcrumb[] = array(
					'url' => $url,
					'label' => $step['label']
				);
			}
		}
	
		$this->breadcrumb[] = array(
			'url' => null,
			'label' => $this->productLabel
		);
		
		return $this->breadcrumb;
	}
	
	public function getResourceId()
	{
		return $this->productId;
	}
	
	public function getTitle()
	{
		return $this->productLabel;
	}
	
	public function getType()
	{
		return "product";
	}
}