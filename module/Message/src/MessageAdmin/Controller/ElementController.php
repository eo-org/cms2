<?php
namespace MessageAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Message\Document\MessageForm;

class ElementController extends AbstractActionController
{	
	public function editAction()
	{
		$id = $this->params()->fromRoute('id');
		
		$form = new MessageFormEditForm();
		$dm = $this->documentManager();
		$doc = null;
		if(empty($id)) {
			$doc = new MessageForm();
		} else {
			$doc = $dm->getRepository('Message\Document\MessageForm')->findOneById($id);
		}
		$form->bind($doc);
		
		 if($this->getRequest()->isPost()) {
        	$postData = $this->getRequest()->getPost();
        	$form->setData($postData);
			if($form->isValid()) {
				$dm->persist($doc);
				$dm->flush();
	            $this->flashMessenger()->addMessage('表单:'.$doc->getLabel().' 已经成功保存');
	            return $this->redirect()->toRoute('admin/actionroutes/wildcard', array('action' => 'index', 'controller' => 'messageadmin-index'));
			}
		}
		
		$this->actionMenu = array('save');
		$this->actionTitle = '新建信息表单';
		
		return array(
			'form' => $form
		);
	}
	
	public function getFormJsonAction()
	{
		$pageSize = 20;
		$postCo = App_Factory::_m('Post');
		$postCo->addFilter("orgCode", Class_Server::getOrgCode());
		$postCo->sort('_id', -1);
		$result = array();
		foreach($this->getRequest()->getParams() as $key => $value) {
			if(substr($key, 0 , 7) == 'filter_') {
				$field = substr($key, 7);
				switch($field) {
					case 'type':
						$postCo->addFilter('formName', new MongoRegex("/^".$value."/"));
						break;
					case 'page':
						if(intval($value) != 0) {
    						$currentPage = $value;
    					}
    					$result['currentPage'] = intval($value);
						break;
				}
			}
		}
		$data = $postCo->fetchAll(true);
		$dataSize = $postCo->count();
		$result['data'] = $data;
		$result['dataSize'] = $dataSize;
		$result['pageSize'] = $pageSize;
		$result['currentPage'] = $currentPage;
		
		return $this->_helper->json($result);
	}
}
