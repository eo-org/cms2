<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class AdController extends AbstractActionController
{	
	public function indexAction()
	{
		$sectionId = $this->params()->fromRoute('section-id');
		
		$this->actionMenu = array(
				array('label' => '添加广告图', 'callback' => '/rest/ad', 'method' => 'createAd')
			);
		$this->actionTitle = '广告图';
		
		return array(
			'sectionId' => $sectionId,
		);
	}
}