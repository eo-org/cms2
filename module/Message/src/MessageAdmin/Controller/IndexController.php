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
	
// 	public function createAction()
// 	{
// 		$form = new MessageFormEditForm();
// 		$dm = $this->documentManager();
// 		$doc = new MessageForm();
// 		$form->bind($doc);
		
// 		if($this->getRequest()->isPost()) {
// 			$postData = $this->getRequest()->getPost();
// 			$form->setData($postData);
// 			if($form->isValid()) {
// 				$dm->persist($doc);
// 				$dm->flush();
// 				$this->flashMessenger()->addMessage('表单:'.$doc->getLabel().' 已经成功保存');
// 				return $this->redirect()->toRoute('admin/actionroutes/wildcard', array('action' => 'index', 'controller' => 'messageadmin-index'));
// 			}
// 		}
		
// 		$this->actionMenu = array('save');
// 		$this->actionTitle = '新建信息表单';
		
// 		return array(
// 			'form' => $form
// 		);
// 	}
	
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
