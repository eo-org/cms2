<?php
namespace Ext\Brick\Product;

use Ext\Brick\AbstractExt;

class Detail extends AbstractExt
{
    public function prepare()
    {
    	$sm = $this->sm;
    	$layoutFront = $this->getLayoutFront();
    	$context = $layoutFront->getContext();
    	$productId = $context->getParam('id');
    	 
    	$factory = $this->dbFactory();
    	$productDoc = $factory->_m('Product')->find($productId);
    	if($context->getType() == 'product' && $productDoc != null) {
//     		$title = $productDoc->label;
//     		if($this->getParam('showHits') == 'y') {
//     			$productDoc->hits++;
//     			$productDoc->save();
//     		}
    	} else {
    		$this->_disableRender = 'brick-product-detail';
    	}
    	$this->view->row = $productDoc;
    }
    
	public function getTplList()
	{
		return array('view' => 'product\detail\view.tpl');
	}
}