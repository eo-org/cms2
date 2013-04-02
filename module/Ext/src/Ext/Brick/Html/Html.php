<?php
namespace Ext\Brick\Html;

use Ext\Brick\AbstractExt;

class Html extends AbstractExt
{
	public function prepare()
    {
		$this->view->content = $this->getParam('content');
    }
    
    public function getFormClass()
    {
    	return 'Ext\Form\Html\Html';
    }
    
    public function getTplList()
    {
    	return array('view' => 'html\html\view.tpl');
    }
}