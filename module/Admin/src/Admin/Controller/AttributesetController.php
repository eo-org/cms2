<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\Attributeset\EditForm;

class AttributesetController extends AbstractActionController
{
	protected $_type = 'product';
	
    public function indexAction()
    {
    	
    }
    
    public function createAction()
    {
    	$type = $this->params('type');
    	
    	if(!in_array($type, array('product'))) {
    		throw new \Exception('attribute type '.$type.' not supported!');
    	}
    	
    	$attributesetDoc = new \Cms\Document\Attributeset();
    	$dm = $this->documentManager();
    	
    	$form = new EditForm();
    	if($this->getRequest()->isPost()) {
    		$postData = $this->getRequest()->getPost();
        	$form->setData($postData);
        	if($form->isValid()) {
	        	$attributesetDoc->exchangeArray($form->getData());
	        	$attributesetDoc->setType($type);
	        	$dm->persist($attributesetDoc);
	        	$dm->flush();
	        	$this->flashMessenger()->addMessage('属性组:'.$attributesetDoc->getLabel().'['.$type.'] 已经成功保存');
	        	return $this->redirect()->toRoute('admin/actionroutes/wildcard', array('action' => 'index', 'controller' => $type.'-type'));
        	}
    	}
    	$this->actionTitle = '新属性组';
    	$this->actionMenu = array('save');
    	return array(
    		'form' => $form
    	);
    }
    
    public function editAction()
    {
        $id = $this->params()->fromRoute('id');
        $dm = $this->documentManager();
        
        $attributesetDoc = $dm->getRepository('Cms\Document\Attributeset')->find($id);
        	
        if(is_null($attributesetDoc)) {
        	throw new Exception('attributeset not found');
        }
        
		$this->actionTitle = '属性组';
		$this->actionMenu = array('delete');
        return array(
        	'id' => $id
        );
    }
    
    public function deleteAction()
    {
    	$id = $this->params()->fromRoute('id');
    	$dm = $this->documentManager();
    	$attributesetDoc = $dm->getRepository('Cms\Document\Attributeset')->find($id);
    	 
    	if(is_null($attributesetDoc)) {
    		throw new Exception('attributeset not found');
    	}
    	 
    	$dm->remove($attributesetDoc);
    	$dm->flush();
    	$this->flashMessenger()->addMessage('产品类型:'.$attributesetDoc->getLabel().'已删除！');
    	return $this->redirect()->toRoute('admin/actionroutes/wildcard', array('action' => 'index', 'controller' => 'product-type'));
    }
    
    public function resortAttributesAction()
    {
    	$attrIdStr = $this->getRequest()->getParam('sortedIdsStr');
    	$attrIdArr = explode(',', $attrIdStr);
    	
    	$attributeCo = App_Factory::_am('Attribute');
    	foreach($attrIdArr as $key => $aId) {
    		$attributeDoc = $attributeCo->find($aId);
    		$attributeDoc->sort = $key;
    		$attributeDoc->save();
    	}
    	
    	$this->_helper->json('ok');
    }
    
//     public function getElementTemplateAction()
//     {
//     	$type = $this->getRequest()->getParam('element-type');
// 		$id = $this->getRequest()->getParam('id');
// 		$attributeCo = App_Factory::_am('Attribute');
// 		$formDoc = $formCo->create();
// 		if($type == 'text' || $type == 'textarea') {
// 			$formDoc->setFromArray(array('formId' => $formid,'elementType'=>$type,'label'=>'标题','required'=>0,'desc'=>'标题描述'));
// 		} else if($type == 'button') {
// 			$formDoc->setFromArray(array('formId' => $formid,'elementType'=>$type,'label'=>'提交','type'=>'submit'));
// 		} else {
// 			$formDoc->setFromArray(array('formId' => $formid,'elementType'=>$type,'label'=>'标题','required'=>0,'desc'=>'标题描述','option'=>array('第一选项','第二选项','第三选项')));
// 		}
// 		$formDoc->save();
// 		$this->view->testid = $formDoc->getId();
// 		switch($type) {
// 			case 'text':
// 				$this->render('element/text');
// 				break;
// 			case 'textarea':
// 				$this->render('element/textarea');
// 				break;
// 			case 'select':
// 				$this->render('element/select');
// 				break;
// 			case 'multi-checkbox':
// 				$this->render('element/multi-checkbox');
// 				break;
// 			case 'menu':
// 				$this->render('element/menu');
// 				break;
// 			case 'button':
// 				$this->render('element/button');
// 				break;
// 		}
// 		$this->getResponse()->setHeader('result', 'success');
//     }
}