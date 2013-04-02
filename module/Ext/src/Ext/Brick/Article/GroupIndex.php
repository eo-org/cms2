<?php
namespace Ext\Brick\Article;

use Ext\Brick\AbstractExt;

class GroupIndex extends AbstractExt
{
	public function prepare()
	{
		$sm = $this->sm;
		$layoutFront = $this->getLayoutFront();
		$context = $layoutFront->getContext();
		
		$groupItemId = $context->getGroupItemId();
		$groupDoc = $context->getGroupDoc();
		if($this->getParam('level') == 'auto') {
			$branchIndex = $groupDoc->getLevelOneTree($groupItemId);
			$branchIndexArr = array($branchIndex);
		} else {
			$branchIndexArr = $groupDoc->groupIndex;
		}
		
		$this->view->branchIndexArr = $branchIndexArr;
		$this->view->currentGroupItemId = $groupItemId;
	}
	
	public function getFormClass()
	{
		return 'Ext\Form\Article\GroupIndex';
	}
	
	public function getTplList()
	{
		return array(
			'view' => 'article\groupindex\view.tpl'
		);
	}
}