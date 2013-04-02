<?php
namespace User;

use Exception;
use Zend\ServiceManager\ServiceManagerAwareInterface, Zend\ServiceManager\ServiceManager;
use Zend\Session\Container;

class SessionUser implements ServiceManagerAwareInterface
{
	private static $_md5salt = 'Hgoc&639Jgo';
	
	/**
	 * 
	 * @var Zend\Session\Container
	 */
	protected $sessionContainer = null;
	protected $sm = null;
	
	protected $userId = null;
	protected $userEmail = null;
	protected $userGroup = null;
	
	public function __construct()
	{
		$this->setFromSession();
	}
	
	public function getUserId()
	{
		return $this->userId;
	}
	
	public function getUserEmail()
	{
		return $this->userEmail;
	}
	
	public function getUserGroup()
	{
		return $this->userGroup;
	}
	
	public function isLogin()
	{
		if(is_null($this->userId)) {
			return false;
		}
		return true;
	}
	
	public function login($email, $password = null)
	{
		if(is_object($email)) {
			$this->userId = $email->getId();
			$this->userEmail = $email->getEmail();
			$this->userGroup = $email->getUserGroup();
			$this->setToSession();
			return true;
		} else {
			$md5Password = $this->getMd5Password($password);
			
			$dm = $this->sm->get('DocumentManager');
			$users = $dm->createQueryBuilder('User\Document\User')
				->field('email')->equals($email)
				->field('password')->equals($md5Password)
				->getQuery()
				->execute();
			if(count($users) == 1) {
				$user = $users->getSingleResult();
				$this->userId = $user->getId();
				$this->userEmail = $user->getEmail();
				$this->userGroup = $user->getUserGroup();
				$this->setToSession();
				return true;
			}
		}
		return false;
	}
	
	public function register($user)
	{
		$email = $user->getEmail();
		$dm = $this->sm->get('DocumentManager');
		$existingUser = $dm->getRepository('User\Document\User')->findOneByEmail($email);
		
		if($existingUser) {
// 			print_r($existingUser);
// 			die();
			return false;
		} else {
			$password = $user->getPassword();
			$md5Password = $this->getMd5Password($password);
			$user->setPassword($md5Password);
			$dm->persist($user);
			$dm->flush();
			return true;
		}
	}

	public function logout()
	{
		$this->userId = null;
		$this->userEmail = null;
		$this->userGroup = null;
		$this->setToSession();
	}
	
	public function setFromSession()
	{
		$sc = $this->getSessionContainer();
		
		$this->userId = $sc->offsetGet('userId');
		$this->userEmail = $sc->offsetGet('userEmail');
		$this->userGroup = $sc->offsetGet('userGroup');
	}
	
	public function setToSession()
	{
		$sc = $this->getSessionContainer();
		$sc->offsetSet('userId', $this->userId);
		$sc->offsetSet('userEmail', $this->userEmail);
		$sc->offsetSet('userGroup', $this->userGroup);
	}
	
	public function getMd5Password($password)
	{
		return md5($password.self::$_md5salt);
	}
	
	/**
	 * 
	 * @return \Zend\Session\Container
	 */
	public function getSessionContainer()
	{
		if(is_null($this->sessionContainer)) {
			$this->sessionContainer = new Container('client\user');
		}
		return $this->sessionContainer;
	}

	public function hasPrivilege($action)
	{
		if($this->isLogin()) {
			if(in_array($action, array('index', 'persional-info', 'change-password', 'logout'))) {
				return true;
			}
		} else {
			if(in_array($action, array('login', 'register', 'forget-passwork'))) {
				return true;
			}
		}
		return false;
	}
	
	public function getHomeLocation()
	{
		if($this->isLogin()) {
			return 'index';
		} else {
			return 'login';
		}
	}
	
	public function setServiceManager(ServiceManager $serviceManager)
	{
		$this->sm = $serviceManager;
	}
}