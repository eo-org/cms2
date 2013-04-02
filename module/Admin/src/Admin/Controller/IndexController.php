<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $this->actionMenu = array();
		$this->actionTitle = 'Dashboard';
    }
}
