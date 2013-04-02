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
    	if($context->getType() != 'book') {
    		throw new \Exception('this extension is only suitable for a book typed layout!');
    	}
    	
    	$bookDoc = $context->getContextDoc();
    	if(is_null($bookDoc)) {
    		$this->_disableRender = 'no-resource';
			return;
    	}
    	$this->view->bookAlias = $bookDoc->alias;
    	$this->view->bookIndex = $bookDoc->bookIndex;
    }
    
    public function getTplList()
    {
    	return array('view' => 'book\index\view.tpl');
    }
}
