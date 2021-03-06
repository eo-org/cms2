<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Serializer\Adapter\Json;
use Admin\Form\Navi\EditForm;

class NaviController extends AbstractActionController
{
	public function indexAction()
	{
		$this->brickConfig()->setActionMenu(array('create'))
			->setActionTitle('目录导航');
	}
    
    public function createAction()
    {
        $form = new EditForm();
        
        $factory = $this->dbFactory();
        $co = $factory->_m('Navi');
        
        if($this->getRequest()->isPost()) {
        	$postData = $this->getRequest()->getPost();
        	$form->setData($postData);
        	if($form->isValid()) {
	            $doc = $co->create();
	            $doc->setFromArray($form->getData());
	            $doc->save();
	            $this->flashMessenger()->addMessage('导航:'.$doc->label.' 已经成功保存');
	            return $this->switchContext("navi");
        	}
        }
        
        $this->brickConfig()->setActionMenu(array('create-save'))
			->setActionTitle('目录导航');
        
        return array('form' => $form);
    }
    
    public function editAction()
    {
    	$id = $this->params()->fromRoute('id');
    	
    	$factory = $this->dbFactory();
        $co = $factory->_m('Navi');
    	$doc = $co->find($id);
    	
    	$this->brickConfig()->setActionMenu(array(
        	'create-link' => array('label' => '添加新连接', 'callback' => '', 'method' => 'showEditor'),
        	'save-sort' => array('label' => '保存结构', 'callback' => '', 'method' => 'saveSort'),
        	'delete'
        ))->setActionTitle('编辑');
        return array(
        	'naviDoc' => $doc
        );
        /*
	 	$this->_helper->template->head('编辑')
        	->actionMenu(array(
        		'create-link' => array('label' => '添加新连接', 'callback' => '', 'method' => 'showEditor'),
        		'save-sort' => array('label' => '保存结构', 'callback' => '', 'method' => 'saveSort'),
        		'delete'
        	));
        	*/
    }
    /*
	public function editLinkAction()
    {
    	$id = $this->getRequest()->getParam('id');
    	$co = App_Factory::_m('Navi_Link');
    	if(!is_null($id)) {
    		$itemDoc = $co->find($id);
    		$naviId = $itemDoc->naviId;
    		$op = 'edit';
    	} else {
    		$itemDoc = $co->create();
    		$naviId = $this->getRequest()->getParam('navi-id');
    		$op = 'create';
    	}
    	if(is_null($naviId)) {
    		throw new Exception('navi id missing');
    	}
    	$naviDoc = App_Factory::_m('Navi')->setFields(array('label'))
    		->find($naviId);
    	
    	require APP_PATH.'/admin/forms/Navi/Link/Edit.php';
    	$form = new Form_Navi_Link_Edit();
    	$form->populate($itemDoc->toArray());
    	if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getParams())) {
    		$itemDoc->setFromArray($form->getValues());
    		if($op == 'create') {
    			$itemDoc->naviId = $naviId;
    			$itemDoc->parentId = '';
    			$itemDoc->sort = 0;
    		}
    		$itemDoc->save();
    		
    		$this->_helper->redirector->gotoSimple('edit', null, null, array('id' => $naviId));
    	}
    	
    	$this->view->form = $form;
    	$this->_helper->template->head('编辑 <em>'.$naviDoc->label.'</em> 章节')
        	->actionMenu(array(
        		'save',
        		'delete-link' => array('label' => '删除链接', 'callback' => '/admin/navi/delete-link/id/'.$id, 'method' => 'link')
        	));
    }
    */
    public function deleteAction()
    {
    	$id = $this->params()->fromRoute('id');
    	$factory = $this->dbFactory();
    	$naviDoc = $factory->_m('Navi')->find($id);
    	if(is_null($naviDoc)) {
    		throw new Exception('navi not found with given id: '.$id);
    	}
    	
    	$naviLinkCo = $factory->_m('Navi_Link');
    	$naviLinkCo->delete(array('naviId' => $naviDoc->getId()));
    	$naviDoc->delete();
    	
    	//$this->_helper->flashMessenger->addMessage('导航栏已经删除');
		return $this->switchContext('navi');
    }
    /*
    public function deleteLinkAction()
    {
    	$id = $this->getRequest()->getParam('id');
    	$co = App_Factory::_m('Navi_Link');
    	$doc = $co->find($id);
    	if(is_null($doc)) {
            throw new Class_Exception_AccessDeny('link not found with given id:'.$id);
        }
        
        $doc->delete();
		
        $this->_helper->flashMessenger->addMessage('连接:'.$doc->label.' 已删除！');
		$this->_helper->switchContent->gotoSimple('edit', 'navi', 'admin', array('id' => $doc->naviId));
    }
    */
    /*
	public function treeSortAction()
    {
    	$treeId = $this->getRequest()->getParam('treeId');
    	$jsonStr = $this->getRequest()->getParam('sortJsonStr');
    	$pageArr = Zend_Json::decode($jsonStr);
    	
    	$descStr = "";
    	$co = App_Factory::_m('Navi_Link');
    	$docs = $co->setFields(array('label', 'parentId', 'sort', 'link', 'className', 'description'))
    		->addFilter('naviId', $treeId)
			->sort('sort', 1)
			->fetchDoc();
    	foreach($docs as $doc) {
    		$pageId = $doc->getId();
    		$newPageValue = $pageArr[$pageId];
    		$sort = intval($newPageValue['sort']);
    		$parentId = $newPageValue['parentId'];
    		if($doc->sort != $sort || $doc->parentId !== $parentId) {
    			$doc->sort = $sort;
    			$doc->parentId = (string)$parentId;
    			$doc->save();
    		}
    		$descStr.= $doc->label.', ';
    	}
    	
    	$treeDoc = App_Factory::_m('Navi')->find($treeId);
    	$treeDoc->setLeafs($docs);
    	$treeIndex = $treeDoc->buildIndex();
    	
    	$treeDoc->naviIndex = $treeIndex;
    	if(strlen($descStr) > 45) {
    		$treeDoc->description = mb_substr($descStr, 0, 45, 'utf-8').' ... ';
    	} else {
    		$treeDoc->description = mb_substr($descStr, 0, -2, 'utf-8');
    	}
    	$treeDoc->save();
    	
    	$this->_helper->json(array('result' => 'success'));
    }
    */
    /*
    public function getNaviJsonAction()
    {
        $pageSize = 20;
		$currentPage = 1;
		
		$co = App_Factory::_m('Navi');
		$co->setFields(array('id', 'label', 'description'));
		$queryArray = array();
		
        $result = array();
        foreach($this->getRequest()->getParams() as $key => $value) {
            if(substr($key, 0 , 7) == 'filter_') {
                $field = substr($key, 7);
                switch($field) {
                	case 'label':
                		$co->addFilter('label', new MongoRegex("/^".$value."/"));
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
        $co->sort('_id', -1);
        
		$co->setPage($currentPage)->setPageSize($pageSize);
		$data = $co->fetchAll(true);
		$dataSize = $co->count();
		
		$result['data'] = $data;
        $result['dataSize'] = $dataSize;
        $result['pageSize'] = $pageSize;
        $result['currentPage'] = $currentPage;
        
        return $this->_helper->json($result);
    }
    */
    
    public function treeSortAction()
    {
    	
    }
    
}