<?php
namespace Ext\Brick\Book;

use Ext\Brick\AbstractExt;

class Index extends AbstractExt
{
    public function prepare()
    {
    	$sm = $this->sm;
		$layoutFront = $this->getLayoutFront();
		
		$context = $layoutFront->getContext();
		$trails = $context->getTrail();
		$trailIds = array();
		 
		if(is_array($trails)) {
			foreach($trails as $t) {
				$trailIds[] = $t['id'];
			}
		}
		
    	if($context->getType() != 'book') {
    		throw new \Exception('this extension is only suitable for a book typed layout!');
    	}
    	
    	$bookDoc = $context->getContextDoc();
    	if(is_null($bookDoc)) {
    		$this->_disableRender = 'no-resource';
			return;
    	}
    	$this->view->trailIds = $trailIds;
    	$this->view->bookAlias = $bookDoc->getAlias();
    	$this->view->bookIndex = $bookDoc->getBookIndex();
    }
    
    public function getTplList()
    {
    	return array('view' => 'book\index\view.tpl');
    }
}
