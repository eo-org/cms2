<?php
namespace Ext\Brick\Article;

use Ext\Brick\AbstractExt;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Null as NullAdapter;

class ContentList extends AbstractExt
{
	public function prepare()
	{
		$sm = $this->sm;
		$layoutFront = $this->getLayoutFront();
		
		$context = $layoutFront->getContext();
		if($context->getType() != 'article-list') {
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
			
			$co = $factory->_m('Article');
			$co->setFields(array('id', 'label', 'introtext', 'introicon', 'created'))
				->addFilter('groupId', $groupId)
				->addFilter('status', 'publish')
				->setPage($page)
				->setPageSize($pageSize)
				->sort('_id', -1);
	        $dataSize = $co->count();
	        $data = $co->fetchDoc();
	        
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
    	return "Ext\Form\Article\ContentList";
    }
    
	public function getTplList()
	{
		return array(
			'view' => 'article\contentlist\view.tpl'
		);
	}
}