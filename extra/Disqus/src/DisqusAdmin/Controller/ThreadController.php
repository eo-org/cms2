<?php
namespace DisqusAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ThreadController extends AbstractActionController
{
	public function indexAction()
	{
		$this->brickConfig()->setActionMenu(array())
			->setActionTitle('留言主题');
	}
	
	public function createAction()
	{
		
	}
	
	public function editAction()
	{
		$this->brickConfig()->setActionMenu(array())
			->setActionTitle('编辑主题');
		
		$threadId = $this->params('id');
		
		return array(
			'threadId' => $threadId
		);
	}
}