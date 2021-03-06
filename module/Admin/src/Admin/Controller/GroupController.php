<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class GroupController extends AbstractActionController
{
    public function indexAction()
    {
    	$this->brickConfig()->setActionMenu(array())
			->setActionTitle('分组管理');
    }
    
    public function editAction()
    {
    	$this->brickConfig()->setActionMenu(array(
        	'create-item' => array('label' => '添加新分类', 'callback' => '', 'method' => 'createLinks'),
        	'save-sort' => array('label' => '保存结构', 'callback' => '', 'method' => 'saveSort')
    	))->setActionTitle('编辑分组');
    	
    	$type = $this->params()->fromRoute('type');
    	if(!in_array($type, array('article', 'product'))) {
    		throw new Exception('group type'.$type.' is not legal');
    	}
    	$factory = $this->dbFactory();
    	$co = $factory->_m('Group');
    	$doc = $co->addFilter('type', $type)
    		->fetchOne();
    	if(is_null($doc)) {
    		$doc = $co->create();
    		$doc->type = $type;
    		$doc->save();
    	}
    	
    	return array(
    		'doc' => $doc,
    		'groupType' => $type
    	);
    }
    
	public function editItemAction()
    {
    	$id = $this->getRequest()->getParam('id');
    	$co = App_Factory::_m('Group_Item');
    	if(!is_null($id)) {
    		$itemDoc = $co->find($id);
    		$groupType = $itemDoc->groupType;
    		$op = 'edit';
    	} else {
    		$itemDoc = $co->create();
    		$groupType = $this->getRequest()->getParam('type');
    		$op = 'create';
    	}
    	if(is_null($groupType)) {
    		throw new Exception('group type missing');
    	}
    	$groupDoc = App_Factory::_m('Group')->setFields(array('label'))
    		->addFilter('type', $groupType)
    		->fetchOne();
    		
    	require APP_PATH.'/admin/forms/Group/Item/Edit.php';
    	$form = new Form_Group_Item_Edit();
    	$form->populate($itemDoc->toArray());
    	if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getParams())) {
    		$itemDoc->setFromArray($form->getValues());
    		if($op == 'create') {
    			$itemDoc->groupType = $groupType;
    			$itemDoc->parentId = '';
    			$itemDoc->sort = 0;
    		}
    		$itemDoc->save();
    		
    		$this->_helper->redirector->gotoSimple('edit', null, null, array('type' => $groupType));
    	}
    	
    	$this->view->form = $form;
    	$this->_helper->template->head('编辑 <em>'.$groupDoc->label.'</em> 章节')
        	->actionMenu(array('save', 'delete'));
    }
    
	public function treeSortAction()
    {
		$treeId = $this->getRequest()->getParam('treeId');
    	$jsonStr = $this->getRequest()->getParam('sortJsonStr');
    	$childArr = Zend_Json::decode($jsonStr);
    	
    	$co = App_Factory::_m('Group_Item');
    	$docs = $co->setFields(array('label', 'parentId', 'sort', 'alias', 'layoutAlias', 'className'))
    		->addFilter('groupType', $treeId)
			->sort('sort', 1)
			->fetchDoc();
    	foreach($docs as $doc) {
    		$childId = $doc->getId();
    		if(isset($childArr[$childId])) {
    			$newChildValue = $childArr[$childId];
    		} else {
    			$newChildValue = array('sort' => 0, 'parentId' => 1);
    		}
    		$sort = intval($newChildValue['sort']);
    		$parentId = $newChildValue['parentId'];
    		if($doc->sort != $sort || $doc->parentId != $parentId) {
    			$doc->sort = $sort;
    			$doc->parentId = $parentId;
    			$doc->save();
    		}
    	}
    	
    	if($treeId == 'article') {
    		$treeDoc = App_Factory::_m('Group')->findArticleGroup();
    	} else if($treeId == 'product') {
    		$treeDoc = App_Factory::_m('Group')->findProductGroup();
    	}
    	$treeDoc->setLeafs($docs);
    	$treeIndex = $treeDoc->buildIndex();
    	$treeDoc->groupIndex = $treeIndex;
    	$treeDoc->save();
    	
    	$this->_helper->json(array('result' => 'success'));
    }
}