<?php
namespace Ext\Brick\AdGroup;

use Ext\Brick\AbstractExt;

class Plain extends AbstractExt
{
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
    	return 'Ext\Form\AdGroup\Plain';
    }
    
    public function getTplList()
    {
    	return array('view' => 'adgroup\plain\view.tpl');
    }
}