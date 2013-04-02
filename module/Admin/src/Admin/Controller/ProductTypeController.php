<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\ProductType\EditForm; 

class ProductTypeController extends AbstractActionController
{
	public function indexAction()
	{
		$this->actionMenu = array(array('label' => '创建新属性', 'callback' => '/admin/attributeset/create/type/product'));
		$this->actionTitle = '产品类型';
	}
}