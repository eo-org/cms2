<?php
namespace Ext\Brick\Position;

use Ext\Brick\AbstractExt;

class Navi extends AbstractExt
{
    public function prepare()
    {
    	$layoutFront = $this->getLayoutFront();
    	$context = $layoutFront->getContext();
    	$trails = $context->getTrail();
    	$trailIds = array();
    	
    	if(is_array($trails)) {
	    	foreach($trails as $t) {
	    		$trailIds[] = $t['id'];
	    	}
    	}
    	
    	$id = $this->getParam('naviId');
    	$factory = $this->dbFactory();
    	$co = $factory->_m('Navi');
    	$doc = $co->find($id);
    	
    	$this->view->naviDoc = $doc;
    	$this->view->trailIds = $trailIds;
    }
    
    public function getFormClass()
    {
    	return 'Ext\Form\Position\Navi';
    }
    
    public function getTplList()
    {
    	return array(
    		'view' => 'position\navi\view.tpl',
    		'loop' => 'position\navi\_loopitem.tpl'
    	);
    }
}
