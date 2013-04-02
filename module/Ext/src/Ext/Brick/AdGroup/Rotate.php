<?php
namespace Ext\Brick\AdGroup;

use Ext\Brick\AbstractExt;

class Rotate extends AbstractExt
{
	protected $_effectFiles = array(
		'ad/rotate.plugin.js'
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
    	return 'Ext\Form\AdGroup\Rotate';
    }
    
    public function getTplList()
    {
    	return array('view' => 'adgroup\rotate\view.tpl');
    }
}