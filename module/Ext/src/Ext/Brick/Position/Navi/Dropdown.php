<?php
namespace Ext\Brick\Position\Navi;

use Ext\Brick\AbstractExt;

class Dropdown extends AbstractExt
{
	protected $_effectFiles = array(
    	'navi/dropdown/plugin.js'
    );
	
    public function prepare()
    {
    	$id = $this->getParam('naviId');
    	$factory = $this->dbFactory();
    	$co = $factory->_m('Navi');
    	$doc = $co->find($id);
    	$this->view->naviDoc = $doc;
    }
    
    public function getFormClass()
    {
    	return 'Ext\Form\Position\Navi\Dropdown';
    }
    
    public function getTplList()
    {
    	return array('view' => 'position\navi\dropdown\view.tpl');
    }
}
