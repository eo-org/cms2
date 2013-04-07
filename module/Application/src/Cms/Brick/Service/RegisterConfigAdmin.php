<?php
namespace Cms\Brick\Service;

use Zend\Mvc\MvcEvent;
use Cms\Brick\Register;

class RegisterConfigAdmin
{
	public function configRegister(Register $register)
	{
		$register->registerBrick(array(
				'Admin\ActionTitle',
				'Admin\ActionMenu'
		));
	}
}