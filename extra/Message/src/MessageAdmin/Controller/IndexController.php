<?php
namespace MessageAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use MessageAdmin\Form\MessageForm as MessageFormEditForm;
use Message\Document\MessageForm;

class IndexController extends AbstractActionController
{
	public function indexAction()
	{
		$this->actionMenu = array(
			'create-edit'
		);
		$this->actionTitle = 'Message Forms';
	}
	
	public function editAction()
	{
		$id = $this->params()->fromRoute('id');
		
		$this->actionMenu = array(
			'save-form' => array('label' => '保存表单', 'callback' => '#', 'method' => '', 'id' => 'save-message-form'),
		);
		$this->actionTitle = '修改信息表单';
		
		return array(
			'messageFormId' => $id
		);
	}
}
