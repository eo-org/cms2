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

use Document\ServiceAccount\Site;

class DomainController extends AbstractRestfulController
{
	public function getList()
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
		$dm = DocumentManager::create(new Connection($accountServer['server']), $config);
		PersistentObject::setObjectManager($dm);
		/** END new connection create **/
		
		$remoteSiteId = $this->siteConfig('remoteSiteId');
		
		$site = $dm->createQueryBuilder('Document\ServiceAccount\Site')
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
		$dm = DocumentManager::create(new Connection($accountServer['server']), $config);
		PersistentObject::setObjectManager($dm);
		/** END new connection create **/
		
		$globalSiteId = $this->siteConfig('globalSiteId');
		//$dm = $this->documentManager();
		
		$dataStr = $data['model'];
		$dataArr = Json::decode($dataStr, Json::TYPE_ARRAY);
		
		$domainName = $dataArr['domainName'];
		$site = $dm->createQueryBuilder('Document\ServiceAccount\Site')
			->field('domains.domainName')->equals($domainName)
			->getQuery()
			->getSingleResult();
		
		if($site !== null) {
			$this->getResponse()->getHeaders()->addHeaderLine('result', 'failed');
			return "域名".$domainName."已经绑定其他网站!请联系客服.";
		}
		
		$site = $dm->createQueryBuilder('Document\ServiceAccount\Site')
			->field('globalSiteId')->equals($globalSiteId)
			->getQuery()
			->getSingleResult();
		$domains = $site->getDomains();
		if(count($domains) >= 4) {
			$this->getResponse()->getHeaders()->addHeaderLine('result', 'failed');
			return "单个网站最多绑定3个域名";
		}
		$domain = new \Document\ServiceAccount\Domain();
		$domain->setFromArray($dataArr);
		
		$site->addDomain($domain);
		$dm->persist($site);
		$dm->flush();
		
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		return $domain->getId();
	}
	
	public function update($id, $data)
	{
		
	}
	
	public function delete($id)
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
		$dm = DocumentManager::create(new Connection($accountServer['server']), $config);
		PersistentObject::setObjectManager($dm);
		/** END new connection create **/
		
		$remoteSiteId = $this->siteConfig('remoteSiteId');
		//$dm = $this->documentManager();
		
		$site = $dm->createQueryBuilder('Document\ServiceAccount\Site')
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
	}
}