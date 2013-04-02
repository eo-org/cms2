<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\Site\EditForm;

class SiteController extends AbstractActionController 
{
	public function indexAction()
    {
    	$this->brickConfig()->setActionMenu(array('save'))->setActionTitle('网站基本信息设定');
    	
    	$form = new EditForm();
    	
    	$factory = $this->dbFactory();
        $co = $factory->_m('Info');
        $doc = $co->fetchOne();
        if(is_null($doc)) {
        	$doc = $co->create();
        }
        $form->setData($doc->toArray());
        if($this->getRequest()->isPost()) {
        	$postData = $this->getRequest()->getPost();
        	$form->setData($postData);
        	if($form->isValid()) {
	        	$doc->setFromArray($form->getData());
	        	$doc->save();
	        	$this->flashMessenger()->addMessage('网站基本信息已经成功保存');
		        return $this->redirect()->toRoute('admin/actionroutes/wildcard', array('action' => 'index', 'controller' => 'site'));
        	}
        }
        
        return array('form' => $form);
    }
    
    public function domainAction()
    {
    	$this->brickConfig()->setActionTitle('网站域名设定')
	    	->setActionMenu(array(
	    		array('label' => '绑定新域名', 'method' => 'bindDomain', 'callback' => '/rest/domain.json')
	    	));
    }
}