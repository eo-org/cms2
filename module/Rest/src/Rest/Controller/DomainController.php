<?php
namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Json\Json;
use Zend\View\Model\JsonModel;
use Doctrine\Common\Persistence\PersistentObject,
Doctrine\ODM\MongoDB\DocumentManager,
Doctrine\ODM\MongoDB\Configuration,
Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver,
Doctrine\MongoDB\Connection;

class DomainController extends AbstractRestfulController
{
	public function getList()
	{
		$dm = $this->connect();
		
		$remoteSiteId = $this->siteConfig('remoteSiteId');
		
		$site = $dm->createQueryBuilder('ServiceAccount\Document\Site')
			->field('_id')->equals($remoteSiteId)
			->hydrate(false)
			->getQuery()
			->getSingleResult();
		
		$domains = $site['domains'];
		foreach($domains as &$domain) {
			$domain['id'] = $domain['_id']->{'$id'};
			unset($domain['_id']);
		}
		return new JsonModel($domains);
	}
	
	public function get($id)
	{
	
	}
	
	public function create($data)
	{
		$dm = $this->connect();
		
		$globalSiteId = $this->siteConfig('globalSiteId');
		//$dm = $this->documentManager();
		
		$dataStr = $data['model'];
		$dataArr = Json::decode($dataStr, Json::TYPE_ARRAY);
		
		$domainName = $dataArr['domainName'];
		$site = $dm->createQueryBuilder('ServiceAccount\Document\Site')
			->field('domains.domainName')->equals($domainName)
			->getQuery()
			->getSingleResult();
		
		if($site !== null) {
			$this->getResponse()->getHeaders()->addHeaderLine('result', 'failed');
			return new JsonModel(array('message' => "域名".$domainName."已经绑定其他网站!请联系客服."));
		}
		
		$site = $dm->createQueryBuilder('ServiceAccount\Document\Site')
			->field('globalSiteId')->equals($globalSiteId)
			->getQuery()
			->getSingleResult();
		$domains = $site->getDomains();
		if(count($domains) >= 5) {
			$this->getResponse()->getHeaders()->addHeaderLine('result', 'failed');
			return new JsonModel(array('message' => 单个网站最多绑定4个域名));
		}
		$domain = new \ServiceAccount\Document\Domain();
		$domain->setFromArray($dataArr);
		
		$site->addDomain($domain);
		$dm->persist($site);
		$dm->flush();
		
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		return new JsonModel(array('id' => $domain->getId()));
	}
	
	public function update($id, $data)
	{
		
	}
	
	public function delete($id)
	{
		$dm = $this->connect();
		
		$remoteSiteId = $this->siteConfig('remoteSiteId');
		//$dm = $this->documentManager();
		
		$site = $dm->createQueryBuilder('ServiceAccount\Document\Site')
			->field('_id')->equals($remoteSiteId)
			->getQuery()
			->getSingleResult();
		
		if($site->removeDomain($id)) {
			$dm->persist($site);
			$dm->flush();
			
			$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		} else {
			$this->getResponse()->getHeaders()->addHeaderLine('result', 'failed');
			$this->getResponse()->getHeaders()->addHeaderLine('responseText', "default domain or domain not found!");
		}
		return new JsonModel(array('id' => $id));
	}
	
	public function connect()
	{
		/** new connection create **/
		$config = new Configuration();
		
		$config->setProxyDir(BASE_PATH . '/cms2/doctrineCache');
		$config->setProxyNamespace('DoctrineMongoProxy');
		$config->setHydratorDir(BASE_PATH . '/cms2/doctrineCache');
		$config->setHydratorNamespace('DoctrineMongoHydrator');
		$config->setMetadataDriverImpl(AnnotationDriver::create(BASE_PATH.'/class'));
		
		$config->setAutoGenerateHydratorClasses(true);
		$config->setAutoGenerateProxyClasses(true);
		
		$accountServer = $this->siteConfig('accountServer');
		$connection = new Connection(CENTER_DB, array(
			'username' => 'craftgavin',
			'password' => 'whothirstformagic?',
			'db' => 'admin'
		));
		$connection->initialize();
		$dm = DocumentManager::create($connection, $config);
		PersistentObject::setObjectManager($dm);
		/** END new connection create **/
		return $dm;
	}
}