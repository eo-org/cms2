<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class TemplateController extends AbstractActionController
{
	public function indexAction()
	{
		
	}
	
	public function activateAction()
	{
		$adapter = Zend_Registry::get('mongoAdapter');
		
		$db = $adapter->getDb();
		
		$collection = $db->selectCollection("system.users");
		
		$users = $collection->find();
		
		$hasUser = false;
		
		foreach($users as $user) {
			$hasUser = true;
		}
		
		if(!$hasUser) {
			$username = 'templateAdmin';
			$password = 'timeToBuildtempLate';
			$collection->insert(array(
				'user' => $username,
				'pwd' => md5($username . ":mongo:" . $password),
				'readOnly' => true
			));
		}
		die();
	}
	
	public function deactivateAction()
	{
		$adapter = Zend_Registry::get('mongoAdapter');
		
		$db = $adapter->getDb();
		
		$collection = $db->selectCollection("system.users");
		
		$collection->remove();
		die();
	}
	
	public function importAction()
	{
		$resetDb = $this->getRequest()->getParam('reset-db');
		$fromSiteId = $this->getRequest()->getParam('site-id');
		
		/****************************/
		/*COPY MONGO DATABASE*/
		/****************************/
		//---->get origin site info through curl
		$ch = curl_init("http://account.enorange.cn/rest/remote-site/".$fromSiteId);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$returnedStr = curl_exec($ch);
		$returnedObj = Zend_Json::decode($returnedStr, Zend_Json::TYPE_OBJECT);
		if($returnedObj->result == 'fail') {
			die($returnedObj->errMsg);
		} else {
			$returnedObj = $returnedObj->data;
		}
		$orgCode = $returnedObj->orgCode;
//		$siteFolder = $returnedObj->siteId;
		$toSiteId = Class_Server::getSiteFolder();
		curl_close($ch);
		
		//---->reset database by copydb command
		if($resetDb == 1) {
			$fromhost = $returnedObj->subdomainName;
			$fromdb = 'cms_'.$returnedObj->remoteId;
			
			$adapter = Zend_Registry::get('mongoAdapter');
			$todb = $adapter->getDbName();
			$db = $adapter->getDb();
			$db->drop();
			
			$mongo = Zend_Registry::get('mongo');
			$connection = $mongo->selectDb('admin');
			
			$username = 'templateAdmin';
			$password = 'timeToBuildtempLate';
			$n = $connection->command(array(
				'copydbgetnonce' => 1,
				'fromhost' => $fromhost
			));
			$saltedHash = md5($n['nonce'].$username.md5($username.":mongo:".$password));
			$result = $connection->command(array(
				'copydb' => 1,
				'fromhost' => $fromhost,
				'fromdb' => $fromdb,
				'todb' => $todb,
				"username" => $username,
			    "nonce" => $n["nonce"],
			    "key" => $saltedHash
			));
		}
		
		/****************************/
		/*DUP ALI FILES & FILE SERVER DATA*/
		/****************************/
		$time = time();
		$fileServerKey = 'gioqnfieowhczt7vt87qhitonqfn8eaw9y8s90a6fnvuzioguifeb';
		$sig = md5($fromSiteId.$time.$toSiteId.$fileServerKey);
		
		$ch = curl_init("http://file.enorange.cn/".$fromSiteId."/default/copy/to-site/id/".$toSiteId);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'X-Sig: '.$sig,
			'X-Time: '.$time
		));
		$returnedStr = curl_exec($ch);
		die('ok');
	}
}