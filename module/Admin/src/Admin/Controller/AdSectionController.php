<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class AdSectionController extends AbstractActionController
{
	public function indexAction()
	{
		$this->actionMenu = array(
				array('label' => '添加新分组', 'callback' => '/rest/ad-section', 'method' => 'createAdSection')
			);
		$this->actionTitle = '广告分组';
	}
}