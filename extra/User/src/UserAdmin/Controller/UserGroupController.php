<?php
namespace UserAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Document\UserGroup;
use UserAdmin\Form\UserGroup\EditForm;

class UserGroupController extends AbstractActionController
{
	public function indexAction()
	{
// 		$this->actionMenu = array('create-edit');
		$this->actionMenu = array();
		$this->actionTitle = '用户权限管理';
	}
	
	public function editAction()
	{
		$id = $this->params('id');
		if(is_null($id)) {
			$userGroupDoc = new UserGroup();
		} else {
			$dm = $this->documentManager();
			$userGroupDoc = $dm->getRepository('User\Document\UserGroup')->findOneById($id);
		}
		
		$form = new EditForm();
		if($this->getRequest()->isPost()) {
			$postData = $this->getRequest()->getPost();
			$form->setData($postData);
			if($form->isValid()) {
	        	$userGroupDoc->exchangeArray($form->getData());
	            $userGroupDoc->save();
	            $this->flashMessenger()->addMessage('用户权限:'.$userGroupDoc->label.' 已经成功保存');
	            return $this->redirect()->toRoute('admin/actionroutes/wildcard', array('action' => 'index', 'controller' => 'useradmin-user-group'));
        	}
		}
		$this->actionMenu = array('save');
		$this->actionTitle = '编辑用户权限分组';
		return array(
			'form' => $form
		);
	}
}
