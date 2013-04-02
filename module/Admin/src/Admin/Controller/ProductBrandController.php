<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Cms\Document\Product\Brand;
use Admin\Form\Product\Brand\EditForm;

class ProductBrandController extends AbstractActionController
{
    public function indexAction()
    {
    	$this->actionMenu = array('create');
    	$this->actionTitle = '商标/品牌 列表';
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
    	
    	$dm = $this->documentManager();
        $doc = null;
        if(empty($id)) {
            $doc = new Brand();
            $doc->setAttributesetId($attributesetId);
        } else {
        	$doc = $dm->getRepository('Cms\Document\Product\Brand')->findOneById($id);
        	$attributesetId = $doc->getAttributesetId();
        }
        
        if(is_null($doc)) {
            throw new Class_Exception_AccessDeny('没有权限访问此内容，或者产品id不存在');
        }
		
		$form->setData($doc->getArrayCopy());
		if($this->getRequest()->isPost()) {
			$postData = $this->getRequest()->getPost();
        	$form->setData($postData);
        	
        	if($form->isValid()) {
	        	$doc->exchangeArray($form->getData());
				$dm->persist($doc);
				$dm->flush();
	            $this->flashMessenger()->addMessage('商标/品牌:'.$doc->getLabel().' 已经成功保存');
	            return $this->redirect()->toRoute('admin/actionroutes/wildcard', array('action' => 'index', 'controller' => 'product-brand'));
        	}
		}
		
		if(empty($id)) {
			$this->actionTitle = '新建产品商标/品牌';
			$this->actionMenu = array('save');
		} else {
			$this->actionTitle = '编辑产品商标/品牌: '.$doc->getLabel();
			$this->actionMenu = array('save', 'delete');
		}
		
		return array(
			'form'			=> $form,
			'brand'		=> $doc,
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