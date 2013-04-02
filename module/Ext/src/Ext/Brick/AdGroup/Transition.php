<?php
namespace Ext\Brick\AdGroup;

use Ext\Brick\AbstractExt;

class Transition extends AbstractExt
{
	protected $_effectFiles = array(
		'ad/transition/plugin.js',
		'ad/transition/plugin.css'
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
    	return 'Ext\Form\AdGroup\Transition';
    }
    
    public function getTplList()
    {
    	return array('view' => 'adgroup\transition\view.tpl');
    }
}