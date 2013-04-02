<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\System\OrgnizationForm;

class SystemController extends AbstractActionController 
{
	public function indexAction()
	{
		$this->brickConfig()->setActionMenu(array())
			->setActionTitle('系统管理');
	}
	
	public function headFileAction()
	{
		$this->brickConfig()->setActionMenu(array())
			->setActionTitle('CSS & JS Files');
		
		$factory = $this->dbFactory();
		$docs = $factory->_m('HeadFile')->fetchDoc();
		
		return array(
			'docs' => $docs
		);
	}
	
	public function transferAction()
	{
		$this->brickConfig()->setActionMenu(array('save'))
			->setActionTitle('转移网站所有权');
		
		$config = $this->getServiceLocator()->get('ConfigObject\EnvironmentConfig');
		$remoteSiteId = $config->remoteSiteId;
		$dm = $this->documentManager();
		$siteDoc = $dm->createQueryBuilder('Document\ServerCenter\Site')
			->field('remoteSiteId')->equals($remoteSiteId)
			->getQuery()
			->getSingleResult();
		
		$form = new OrgnizationForm();
		$form->setData($siteDoc->toArray());
		if($this->getRequest()->isPost()) {
        	$postData = $this->getRequest()->getPost();
        	$form->setData($postData);
        	if($form->isValid()) {
	        	$siteDoc->setFromArray($form->getData());
	        	$dm->flush($siteDoc);
	        	$this->flashMessenger()->addMessage('网站基本信息已经成功保存');
		        return $this->redirect()->toRoute('admin/actionroutes/wildcard', array('action' => 'index', 'controller' => 'system'));
        	}
        }
		
		return array(
			'form' => $form
		);
	}
}