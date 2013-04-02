<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Form\LoginForm, User\Form\RegisterForm, User\Form\ChangePasswordForm;
use User\Document\User as UserDocument;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	$sessionUser = $this->getServiceLocator()->get('User\SessionUser');
    	return array(
    		'userEmail' => $sessionUser->getUserEmail()
    	);
    }
    
    public function registerAction()
    {
    	$form = new RegisterForm();
    	if($this->getRequest()->isPost()) {
    		$validateResult = true;
    		
    		$user = new UserDocument();
    		$form->bind($user);
    		$postData = $this->getRequest()->getPost();
    		$postData['userGroup'] = 'online';
    		$form->setData($postData);
    		
    		if(!$form->isValid()) {
    			$formError = "您填写的信息有误";
    			$validateResult = false;
    		}
    		if($form->getInputFilter()->getValue('password') !== $form->getInputFilter()->getValue('password_2')) {
    			$formError = "您填写的密码有不一致";
    			$validateResult = false;
    		}
    		if($validateResult) {
	    		$sessionUser = $this->getServiceLocator()->get('User\SessionUser');
	    		$validateResult = $sessionUser->register($user);
	    		if(!$validateResult) {
	    			$formError = "注册的用户已经存在";
	    		}
    		}
    		if(!$validateResult) {
    			echo $formError;
    		} else {
    			$sessionUser->login($user);
    			return $this->redirect()->toUrl('/user');
    		}
    	}
    	return array(
    		'form' => $form
    	);
    }
    
    public function loginAction()
    {
    	$form = new LoginForm();
    	if($this->getRequest()->isPost()) {
    		$postData = $this->getRequest()->getPost();
    		$sessionUser = $this->getServiceLocator()->get('User\SessionUser');
    		if($sessionUser->login($postData['email'], $postData['password'])) {
    			return $this->redirect()->toUrl('/user');
    		}
    	}
    	return array(
    		'form' => $form
    	);
    }
    
    public function logoutAction()
    {
    	$sessionUser = $this->getServiceLocator()->get('User\SessionUser');
    	$sessionUser->logout();
    	
    	return $this->redirect()->toUrl('/user/login');
    }
    
    public function changePasswordAction()
    {
    	$form = new ChangePasswordForm();
    	if($this->getRequest()->isPost()) {
    		
    	}
    	return array(
    		'form' => $form
    	);
    }
}
