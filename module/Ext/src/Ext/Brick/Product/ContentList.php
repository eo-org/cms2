<?php
namespace Ext\Brick\Product;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Null as NullAdapter;
use Ext\Brick\AbstractExt;

class ContentList extends AbstractExt
{
	public function prepare()
	{
		$sm = $this->sm;
		$layoutFront = $this->getLayoutFront();
		
		$context = $layoutFront->getContext();
		if($context->getType() != 'product-list') {
			$this->_disableRender = 'no-resource';
			return false;
		}
		
		$pageSize = $this->getParam('pageSize');
		if(empty($pageSize)) {
			$pageSize = 20;
		}
		$page = $context->getParam('page');
		
		$groupItemDoc = $context->getGroupItemDoc();
		if($groupItemDoc == 'not-found' || $groupItemDoc == null) {
			$this->_disableRender = 'no-resource';
			return;
		} else {
			$groupId = $groupItemDoc->getId();
			$factory = $this->dbFactory();
				
			$co = $factory->_m('Product');
			$co->setFields(array('id', 'name', 'sku', 'label', 'introicon', 'introtext', 'price', 'attributeDetail', 'attachment', 'weight', 'publishDate'))
				->addFilter('groupId', $groupId)
				->addFilter('status', 'publish')
				->setPage($page)
				->setPageSize($pageSize);
			switch($this->getParam('defaultSort')) {
				case 'pd':
					$co->sort('publishDate', -1);
					break;
				case 'sw':
					$co->sort('weight', 1);
					break;
				case 'sc':
					$co->sort('_id', -1);
					break;
				case 'sn':
					$co->sort('label', 1);
					break;
			}
			
			$query = $context->getQuery();
			foreach($query as $code => $optVal) {
				if($optVal != 'all') {
					$fieldName = 'attributes.'.$code;
					$co->addFilter($fieldName, $optVal);
				}
			}
			$dataSize = $co->count();
			$data = $co->fetchDoc();
			foreach($data as $dataRow) {
				if(is_object($dataRow->publishDate)) {
					$dataRow->publishDate = date('Y-m-d', $dataRow->publishDate->sec);;
				}
			}
			$paginator = new Paginator(new NullAdapter($dataSize));
			Paginator::setDefaultScrollingStyle('Sliding');
			$paginator->setCurrentPageNumber($page)
				->setItemCountPerPage($pageSize);
			$pages = $paginator->getPages();
			 
			$this->view->title = $groupItemDoc->label;
			$this->view->rowset = $data;
				
			$this->view->pages = $pages;
			$this->view->routeMatchParams = $context->getRouteParams();
		}
	}
	
	public function getFormClass()
	{
		return 'Ext\Form\Product\ContentList';
	}
	
	public function getTplList()
	{
		return array(
			'view' => 'product\contentlist\view.tpl',
			'gallery' => 'product\contentlist\gallery.tpl'
		);
	}
}
