<?php
namespace UserAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use UserAdmin\Form\Index\ConfigForm;

class IndexController extends AbstractActionController
{
	public function indexAction()
	{
		$this->actionMenu = array();
		$this->actionTitle = '用户管理';
	}
	
	public function configAction()
	{
		$dm = $this->documentManager();
		$configDoc = $dm->createQueryBuilder('User\Document\Config')
			->getQuery()
			->getSingleResult();
		if(is_null($configDoc)) {
			$configDoc = new \User\Document\Config();
		}
		
		$form = new ConfigForm();
		$factory = $this->dbFactory();
		$groupDoc = $factory->_m('Group')->addFilter('type', 'article')
			->fetchOne();
		$items = $groupDoc->toMultioptions('label');
		$form->get('protectedResourceId')->setValueOptions($items);
		$form->setData($configDoc->getArrayCopy());
		
		if($this->getRequest()->isPost()) {
			$postData = $this->getRequest()->getPost();
			$form->setData($postData);
			if($form->isValid()) {
				$configDoc->exchangeArray($form->getData());
				$dm->persist($configDoc);
				$dm->flush();
			}
		}
		
		$this->actionMenu = array('save');
		$this->actionTitle = '用户管理模块设置';
		return array(
			'form' => $form
		);
	}
}