<?php
namespace MessageRest\Controller;

use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractRestfulController;
use Message\Document\MessageForm;

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
		return new JsonModel($messageForm->getArrayCopy());
	}
	
	public function create($data)
	{
		$dm = $this->documentManager();
		
		$messageForm = new MessageForm();
		$messageForm->exchangeArray($data);
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