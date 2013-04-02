<?php
namespace Ext\Brick\AdGroup;

use Ext\Brick\AbstractExt;

class FancyTransition extends AbstractExt
{
	protected $_effectFiles = array(
    	'ad/fancy-transition.plugin.js'
    );
	
	public function prepare()
    {
    	$factory = $this->dbFactory();
    	$sectionId = $this->getParam('sectionId');
    	 	
    	$co = $factory->_m('Ad');
    	$rowset = $co->addFilter('sectionId', $sectionId)
    		->fetchDoc();
    	
        $this->view->rowset = $rowset;
    }
    
	public function getFormClass()
    {
    	return 'Ext\Form\AdGroup\FancyTransition';
    }
    
    public function getTplList()
    {
    	return array('view' => 'adgroup\fancytransition\view.tpl');
    }
}