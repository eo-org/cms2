<?php
namespace Ext\Brick\Article;

use Ext\Brick\AbstractExt;

class News extends AbstractExt
{
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
		$co = $factory->_m('Article');
		$co->setFields(array('groupId', 'label', 'introtext', 'introicon', 'created', 'modified', 'featured'))
			->addFilter('status', 'publish')
			->setPagesize($this->getParam('limit'))
			->setPage(1)
			->sort('_id', -1);
		if($groupId != 'all') {
			$co->addFilter('groupId', $groupId);
		}
    	$rowset = $co->fetchDoc();
    	
    	$this->view->groupId = $groupId;
		$this->view->groupRow = $groupDoc;
		$this->view->articalRowset = $rowset;
		$this->view->title = $title;
    }
    
    public function getFormClass()
    {
    	return 'Ext\Form\Article\News';
    }
    
    public function getTplList()
    {
    	return array(
    		'view' => 'article\news\view.tpl'
    	);
    }
}