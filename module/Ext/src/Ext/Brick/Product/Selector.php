<?php
namespace Ext\Brick\Product;

use Ext\Brick\AbstractExt;

class Selector extends AbstractExt
{
    public function prepare()
    {
    	$layoutFront = $this->getLayoutFront();
    	
    	$context = $layoutFront->getContext();
    	if($context->getType() != 'product-list') {
    		$this->_disableRender = 'no-resource';
    		return false;
    	}
    	$currentQuery = $context->getQuery()->toArray();
    	$filters = $this->getParam('filters');
    	$filterArr = \Zend\Json\Json::decode($filters, \Zend\Json\Json::TYPE_ARRAY);
    	
    	$dm = $this->documentManager();
		$qb = $dm->createQueryBuilder('Cms\Document\Attribute');
		$cursor = $qb->field('UUID')->in($filterArr)
			->sort('sort', -1)
			->getQuery()
			->execute();
		$selectorArr = array();
		foreach($cursor as $data) {
			$code = $data->getCode();
			$selectorArr[$code] = array(
				'label' => $data->getLabel(),
				'optVal' => $data->getOptions()
			);
		}
    	
    	$this->view->currentQuery = $currentQuery;
    	$this->view->filterArr = $selectorArr;
    }
    
	public function getFormClass()
    {
    	return 'Ext\Form\Product\Selector';
    }
    
    public function getTplList()
    {
    	return array('view' => 'product\selector\view.tpl');
    }
}