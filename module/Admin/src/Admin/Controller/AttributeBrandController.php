<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\AttributeBrand\EditForm;

class AttributeBrandController extends AbstractActionController
{
    public function indexAction()
    {
    	
    }
    
    public function createAction()
    {
    	$attributesBrandDoc = new \Cms\Document\Attribute\Brand();
    	$dm = $this->documentManager();
    	 
    	$form = new EditForm();
    	if($this->getRequest()->isPost()) {
    		$postData = $this->getRequest()->getPost();
    		$form->setData($postData);
    		if($form->isValid()) {
    			$attributesBrandDoc->exchangeArray($form->getData());
    			$dm->persist($attributesBrandDoc);
    			$dm->flush();
    			$this->flashMessenger()->addMessage('商标:'.$attributesBrandDoc->getLabel().' 已经成功保存');
    			return $this->redirect()->toRoute('admin/actionroutes/wildcard', array('action' => 'index', 'controller' => $type.'-type'));
    		}
    	}
    	$this->actionTitle = '新商标';
    	$this->actionMenu = array('save');
    	return array(
    		'form' => $form
    	);
    }
    
    public function editAction()
    {
    	$id = $this->params()->fromRoute('id');
    	
    	$dm = $this->documentManager();
    	$attributeBrandDoc = $dm->getRepository('Cms\Document\AttributeBrand')->find($id);
    	 
    	if(is_null($attributeBrandDoc)) {
    		throw new Exception('attribute/brand not found with id '.$id);
    	}
    	
    	$this->actionTitle = '商标';
    	$this->actionMenu = array('delete');
    	return array(
    		'id' => $id
    	);
    }
    
    public function deleteAction()
    {
    	
    }
}