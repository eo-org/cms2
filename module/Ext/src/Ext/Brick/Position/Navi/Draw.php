<?php
namespace Ext\Brick\Position\Navi;

use Ext\Brick\AbstractExt;

class Draw extends AbstractExt
{
	protected $_effectFiles = array(
    	'navi/draw/plugin.js',
		'navi/draw/plugin.css'
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
    	return 'Ext\Form\Position\Navi\Draw';
    }
    
    public function getTplList()
    {
    	return array('view' => 'position\navi\draw\view.tpl');
    }
}
