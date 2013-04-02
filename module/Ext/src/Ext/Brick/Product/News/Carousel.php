<?php
namespace Ext\Brick\Product\News;

use Ext\Brick\AbstractExt;

class Carousel extends AbstractExt
{
	protected $_effectFiles = array(
    	'product/news/carousel/plugin.js'
    );
	
    public function prepare()
    {
        $groupId = $this->getParam('groupId');
    	if(is_null($groupId)) {
    		$groupId = 0;
    	}
    	
    	$factory = $this->dbFactory();
    	$groupDoc = $factory->_m('Group_Item')->find($groupId);
    	$title = "";
    	if(!is_null($groupDoc)) {
    		$title = $groupDoc->label;
    	}
		$co = $factory->_m('Product');
		$co->setFields(array('id', 'name', 'sku', 'label', 'introicon', 'introtext', 'price'))
			->addFilter('status', 'publish')
			->setPagesize($this->getParam('limit'))
			->setPage(1)
			->sort('_id', -1);
		if($groupId != 'all') {
			$co->addFilter('groupId', $groupId);
		}
		
		$rowset = $co->fetchDoc();
		
    	$this->view->groupId = $groupId;
		$this->view->rowset = $rowset;
		$this->view->title = $title;
    }
    
    public function getFormClass()
    {
    	return 'Ext\Form\Product\News\Carousel';
    }
    
    public function getTplList()
    {
    	return array('view' => 'product\news\carousel\view.tpl');
    }
}