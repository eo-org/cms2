<?php
namespace Ext\Brick\Book;

use MongoId;
use Ext\Brick\AbstractExt;

class PageDetail extends AbstractExt
{
    public function prepare()
    {
    	$sm = $this->sm;
		$layoutFront = $this->getLayoutFront();
		$context = $layoutFront->getContext();
		
		if($context->getType() != 'book') {
			throw new Exception('this extension is only suitable for a book typed layout!');
		}
		
    	$pageDoc = $context->getSubjectDoc();
    	
    	$this->view->label = $pageDoc->getLabel();
    	$this->view->fulltext = $pageDoc->getFulltext();
    }
    
    public function getFormClass()
    {
    	return 'Ext\Form\Book\PageDetail';
    }
    
    public function getTplList()
    {
    	return array('view' => 'book\pagedetail\view.tpl');
    }
}