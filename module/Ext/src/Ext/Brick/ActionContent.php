<?php
namespace Ext\Brick;

use Ext\Brick\AbstractExt;

class ActionContent extends AbstractExt
{
	public function prepare()
	{
		$controller = $this->getController();
		
		$content = $controller->layout()->content;
		
		$this->view->content = $content;
	}
	
	public function getTplList()
	{
		return array('view' => 'actioncontent/view.tpl');
	}
}