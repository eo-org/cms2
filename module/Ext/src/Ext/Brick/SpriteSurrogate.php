<?php
namespace Ext\Brick;

use Ext\Brick\AbstractExt;

class SpriteSurrogate extends AbstractExt
{
	protected $_effectFiles = array(
		'sprite-surrogate/plugin.js'
	);
	
    public function prepare()
    {
    	$sm = $this->sm;
    	$layoutFront = $this->getLayoutFront();
    	$br = $layoutFront->getBrickRegister();
    	$surrogateId = 'surrogate-'.$this->_brick->getId();
    	$tabs = $br->getBrickList($surrogateId);
    	
    	$this->view->tabs = $tabs;
		$this->view->stageId = $this->_brick->stageId;
    }
    
    public function getTplList()
    {
    	return array('view' => 'spritesurrogate\view.tpl');
    }
}