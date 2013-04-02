<?php
namespace Admin\Controller;

use Cms\Document\Product;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\Product\EditForm;

class ProductController extends AbstractActionController
{
    public function indexAction()
    {
		$this->actionMenu = array('create');
		$this->actionTitle = '产品列表';
		
		$factory = $this->dbFactory();
		$groupDoc = $factory->_m('Group')->findProductGroup();
    	$optVal = $groupDoc->toMultioptions('label');
		
		return array(
			'optVal' => $optVal
		);
    }
	
	public function createAction()
	{
		$factory = $this->dbFactory();
		$attributesetCo = $factory->_m('Attributeset');
		
		$attrDocSet = $attributesetCo->setFields(array('label'))
			->addFilter('type', 'product')
			->fetchAll();
		
		$this->actionMenu = array();
		$this->actionTitle = '选择产品类型';
		
		return array(
			'attrRowset' => $attrDocSet
		);
	}
	
	public function editAction()
	{
		$id = $this->params()->fromRoute('id');
		$attributesetId = $this->params()->fromRoute('attributeset-id');
		$form = new EditForm();
		
		$factory = $this->dbFactory();
		$groupDoc = $factory->_m('Group')->addFilter('type', 'product')
    		->fetchOne();
    	$items = $groupDoc->toMultioptions('label');
    	$form->get('groupId')->setValueOptions($items);
    	
    	$dm = $this->documentManager();
        $doc = null;
        if(empty($id)) {
            $doc = new Product();
            $doc->setAttributesetId($attributesetId);
        } else {
        	$doc = $dm->getRepository('Cms\Document\Product')->findOneById($id);
        	$attributesetId = $doc->getAttributesetId();
        }
        
        if(is_null($doc)) {
            throw new Class_Exception_AccessDeny('没有权限访问此内容，或者产品id不存在');
        }
		
		$attributesetDoc = $dm->getRepository('Cms\Document\Attributeset')->findOneById($attributesetId);
		if(!is_null($attributesetDoc)) {
			$attrList = $attributesetDoc->getAttributeList();
		} else {
			$attrList = array();
		}
		$doc->setAttributesetDoc($attributesetDoc);
		
		$fs = $form->attributesFieldset;
		foreach($attrList as $key => $attr) {
			$el = $attr->getFormElement();
			$fs->add($el);
		}
		$form->setData($doc->toArray());
		
		if($this->getRequest()->isPost()) {
			$postData = $this->getRequest()->getPost();
        	$form->setData($postData);
        	
        	if($form->isValid()) {
	        	$doc->exchangeArray($form->getData());
	    		$attaUrl	= $postData->get('attaUrl');
				$attaName	= $postData->get('attaName');
				$attaType	= $postData->get('attaType');
				$doc->clearAttachment();
				if(!is_null($attaUrl)) {
					$doc->setAttachment($attaUrl, $attaName, $attaType);
				}
				$dm->persist($doc);
				$dm->flush();
	            $this->flashMessenger()->addMessage('产品:'.$doc->getLabel().' 已经成功保存');
	            return $this->redirect()->toRoute('admin/actionroutes/wildcard', array('action' => 'index', 'controller' => 'product'));
        	}
		}
		
		$co = $factory->_m('Info');
		$infoDoc = $co->fetchOne();
		
		$thumbWidth = empty($infoDoc->thumbWidth) ? 200 : $infoDoc->thumbWidth;
		$thumbHeight = empty($infoDoc->thumbHeight) ? 200 : $infoDoc->thumbHeight;
		$siteId = $this->siteConfig('remoteSiteId');
		
		$time = time();
		$fileServerKey = 'gioqnfieowhczt7vt87qhitonqfn8eaw9y8s90a6fnvuzioguifeb';
		$sig = md5($siteId.$time.$fileServerKey);
        
		if(empty($id)) {
			$this->actionTitle = '新建产品['.$attributesetDoc->getLabel().']';
			$this->actionMenu = array('save');
		} else {
			$this->actionTitle = '编辑产品['.$attributesetDoc->getLabel().']: '.$doc->getLabel();
			$this->actionMenu = array('save', 'delete');
		}
		
		return array(
			'form'			=> $form,
			'product'		=> $doc,
			'thumbWidth'	=> $thumbWidth,
			'thumbHeight'	=> $thumbHeight,
			'time'			=> $time,
			'sig'			=> $sig
		);
	}
	
	public function deleteAction()
	{
		$id = $this->params()->fromRoute('id');
		
		$factory = $this->dbFactory();
		$productCo = $factory->_m('Product');
		$productDoc = $productCo->find($id);
		
		if($productDoc == null){
			throw new Class_Exception_Pagemissing();
		}
		$productName = $productDoc->label;
		$productDoc->delete();
		$this->flashMessenger()->addMessage('产品 '.$productName.' 已经删除');
		return $this->redirect()->toRoute('admin/actionroutes/wildcard', array('action' => 'index', 'controller' => 'product'));
	}
}