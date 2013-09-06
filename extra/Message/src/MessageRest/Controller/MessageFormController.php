<?php
namespace MessageRest\Controller;

use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractRestfulController;
use Message\Document\MessageForm;
//use Message\Document\Element;

class MessageFormController extends AbstractRestfulController
{
	public function getList()
	{
		$filter = $this->getRequest()->getQuery();
		
		$currentPage = $filter['page'];
		if(empty($currentPage)) {
			$currentPage = 1;
		}
		$pageSize = 100;
		$skip = $pageSize * ($currentPage - 1);
		
		$dm = $this->documentManager();
		$qb = $dm->createQueryBuilder('Message\Document\MessageForm');
		$cursor = $qb->sort('_id', -1)
			->hydrate(false)
			->getQuery()
			->execute();
		$data = $this->formatData($cursor);
		$dataSize = $qb->getQuery()->execute()->count();
		
		$result = array();
		$result['data'] = $data;
		$result['dataSize'] = $dataSize;
		$result['pageSize'] = $pageSize;
		$result['currentPage'] = $currentPage;
		
		return new JsonModel($result);
	}
	
	public function get($id)
	{
		$dm = $this->documentManager();

		$messageForm = $dm->getRepository('Message\Document\MessageForm')->findOneById($id);
// 		$elements = $messageForm->getElements();
		
// 		foreach($elements as $e) {
// 			echo $e->getLabel();
// 		}
		//print_r($messageForm);
		return new JsonModel($messageForm->getArrayCopy());
	}
	
	public function create($data)
	{
		$dm = $this->documentManager();
		
		/*
		$dataStr = $data['model'];
		$dataArr = Json::decode($dataStr, Json::TYPE_ARRAY);
		
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
		*/
		
		$messageForm = new MessageForm();
		$messageForm->exchangeArray($data);
// 		$elementsArr = 
// 		foreach($data) {
			
// 		}
// 		$messageForm->setElements($elements);
		$dm->persist($messageForm);
		$dm->flush();
		
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		return new JsonModel(array('id' => $messageForm->getId()));
	}
	
	public function update($id, $data)
	{
		$dm = $this->documentManager();
		
		$messageForm = $dm->getRepository('Message\Document\MessageForm')->findOneById($id);
		if(is_null($messageForm)) {
			$this->getResponse()->getHeaders()->addHeaderLine('result', 'fail');
			$this->getResponse()->getHeaders()->addHeaderLine('errorMessage', 'form not found with id '.$id);
		} else {
			$messageForm->exchangeArray($data);
			$dm->persist($messageForm);
			$dm->flush();
			$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		}
		
		return new JsonModel(array('id' => $messageForm->getId()));
	}
	
	public function delete($id)
	{
		$dm = $this->documentManager();
		$doc = $dm->getRepository('Disqus\Document\Post')->find($id);
		$dm->remove($doc);
		$dm->flush();
		return new JsonModel(array('id' => $id));
	}
}