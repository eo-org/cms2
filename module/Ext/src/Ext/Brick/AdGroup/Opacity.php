<?php
namespace Ext\Brick\AdGroup;

use Ext\Brick\AbstractExt;

class Opacity extends AbstractExt
{
	protected $_effectFiles = array(
    	'ad/opacity.plugin.js'
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
    	return 'Ext\Form\AdGroup\Opacity';
    }
    
    public function getTplList()
    {
    	return array('view' => 'adgroup\opacity\view.tpl');
    }
}