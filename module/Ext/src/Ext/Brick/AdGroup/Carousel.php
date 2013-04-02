<?php
namespace Ext\Brick\AdGroup;

use Ext\Brick\AbstractExt;

class Carousel extends AbstractExt
{
	protected $_effectFiles = array(
    		'ad/carousel.plugin.js'
    );
	
	public function prepare()
    {
    	$sectionId = $this->getParam('sectionId');
    	
    	$factory = $this->dbFactory();
    	$co = $factory->_m('Ad');
    	$rowset = $co->addFilter('sectionId', $sectionId)
    		->fetchDoc();
    	
        $this->view->rowset = $rowset;
    }
    
	public function getFormClass()
    {
    	return 'Ext\Form\AdGroup\Carousel';
    }
    
    public function getTplList()
    {
    	return array('view' => 'adgroup\carousel\view.tpl');
    }
}