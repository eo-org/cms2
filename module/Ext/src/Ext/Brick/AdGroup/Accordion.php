<?php
namespace Ext\Brick\AdGroup;

use Ext\Brick\AbstractExt;

class Accordion extends AbstractExt
{
	protected $_effectFiles = array(
		'ad/accordion/plugin.js',
		'ad/accordion/plugin.css'
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
    	return 'Ext\Form\AdGroup\Accordion';
    }
    
    public function getTplList()
    {
    	return array('view' => 'adgroup\accordion\view.tpl');
    }
}