<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\Book\EditForm;
use Admin\Form\Book\Page\EditForm as PageEditForm;

class BookController extends AbstractActionController
{
    public function indexAction()
    {
        $this->actionMenu = array('create-edit');
		$this->actionTitle = '手册列表';
    }
    
    public function editAction()
    {
    	$id = $this->params()->fromRoute('id');
		$form = new EditForm();
    	
    	$factory = $this->dbFactory();
    	$co = $factory->_m('Book');
    	
    	if(empty($id)) {
            $doc = $co->create();
        } else {
        	$doc = $co->find($id);
        }
    	if(is_null($doc)) {
            throw new Class_Exception_AccessDeny('没有权限访问此内容，或者内容id不存在');
        }
        $form->setData($doc->toArray());
    	if($this->getRequest()->isPost()) {
    		$postData = $this->getRequest()->getPost();
        	$form->setData($postData);
        	if($form->isValid()) {
	    		$doc = $doc->setFromArray($form->getData());
	    		$doc->save();
	    		$this->flashMessenger()->addMessage('手册:'.$doc->label.' 已经成功保存');
		        return $this->redirect()->toRoute('admin/actionroutes/wildcard', array('action' => 'index', 'controller' => 'book'));
	        }
    	}
    	if(empty($id)) {
    		$this->actionTitle = '新建手册';
    		$this->actionMenu = array('save');
    	} else {
    		$this->actionTitle = '编辑手册: '.$doc->label;
    		$this->actionMenu = array('save', 'delete');
    	}
    	return array(
    		'form' => $form
    	);
    }
    
	public function editPageIndexAction()
    {
    	$id = $this->params()->fromRoute('id');
    	
    	$co = $this->dbFactory()->_m('Book');
		$doc = $co->find($id);
    	
    	$this->actionTitle = '整理书页: '.$doc->label;
        $this->actionMenu = array(
        		'create-page' => array('label' => '添加新书页', 'callback' => '/admin/book/edit-page/book-id/'.$id),
        		'save-sort' => array('label' => '保存结构', 'callback' => '', 'method' => 'saveSort'),
        		'delete'
        	);
        return array(
        	'doc' => $doc
        );
    }
    
    public function editPageAction()
    {
    	$id = $this->params('id');
    	$editor = $this->params()->fromQuery('editor');
    	
    	$factory = $this->dbFactory();
    	$co = $factory->_m('Book_Page');
    	if(!is_null($id)) {
    		$pageDoc = $co->find($id);
    		$bookId = $pageDoc->bookId;
    		$op = 'edit';
    	} else {
    		$pageDoc = $co->create();
    		$bookId = $this->params('book-id');
    		$op = 'create';
    	}
    	if(is_null($editor)) {
    		$editor = $pageDoc->editor;
    	}
    	
    	if(is_null($bookId)) {
    		throw new Exception('book id missing');
    	}
    	$bookDoc = $factory->_m('Book')->setFields(array('label'))
    		->find($bookId);
    	
    	$form = new PageEditForm();
    	if($editor == 'cm') {
    		$textEditor = $form->get('fulltext');
    		$textEditor->setAttributes(array('id' => 'codemirror-editor', 'class' => 'cm'));
    	}
    	$form->setData($pageDoc->toArray());
    	if($this->getRequest()->isPost()) {
    		$postData = $this->getRequest()->getPost();
        	$form->setData($postData);
        	if($form->isValid()) {
	    		$pageDoc->setFromArray($form->getData());
	    		if($op == 'create') {
	    			$pageDoc->bookId = $bookId;
	    			$pageDoc->parentId = '';
	    			$pageDoc->sort = 0;
	    		}
	    		if($editor == 'cm') {
	    			$pageDoc->editor = 'cm';
	    		} else {
	    			$pageDoc->editor = 'ck';
	    		}
	    		$pageDoc->save();
	    		return $this->redirect()->toRoute('admin/actionroutes/wildcard', array('action' => 'edit-page-index', 'controller' => 'book', 'id' => $bookId));
    		}
    	}
    	
    	if(!is_null($id)) {
    		$this->actionTitle = '编辑书页';
    		$this->actionMenu = array('save', 'delete');
    	} else {
    		$this->actionTitle = '新增加书页';
    		$this->actionMenu = array('save');
    	}
    	return array(
    		'form' => $form,
    		'editor' => $editor
    	);
    }
}
