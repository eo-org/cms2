<?php
namespace Ext\Brick\Im;

use Ext\Brick\AbstractExt;

class Im extends AbstractExt
{
    public function prepare()
    {
    	$qqArr = explode(':', $this->getParam('qq'));
		$msnArr = explode(':',$this->getParam('msn'));
		$wwArr = explode(':',$this->getParam('ww'));
    	$this->view->qqArr = $qqArr;
		$this->view->msnArr = $msnArr;
		$this->view->wwArr = $wwArr;
    }
    
	public function getFormClass()
	{
		return 'Ext\Form\Im\Im';
	}
	
	public function getTplList()
	{
		return array(
			'view' => 'im\im\view.tpl',
		);
	}
}