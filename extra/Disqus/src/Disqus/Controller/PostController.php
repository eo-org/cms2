<?php
namespace Disqus\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Disqus\Document\Thread,
Disqus\Document\Post;

class PostController extends AbstractRestfulController
{
	public function getList()
	{
		$filter = $this->getRequest()->getQuery();
		$resourceId = $filter['resourceId'];
		
		$currentPage = $filter['page'];
		if(empty($currentPage)) {
			$currentPage = 1;
		}
		$pageSize = 100;
		$skip = $pageSize * ($currentPage - 1);
		
		$dm = $this->documentManager();
		$threadDoc = $dm->getRepository('Disqus\Document\Thread')->findOneBy(array('resourceId' => $resourceId));
		if($threadDoc == null) {
			return new JsonModel(array());
		}
		$threadId = $threadDoc->getId();
		
		$threadQuery = $dm->createQueryBuilder('Disqus\Document\Post');
		$qb = $threadQuery->field('threadId')->equals($threadId);
		$cursor = $qb->limit($pageSize)->skip($skip)
			->sort('_id', -1)
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
		$result['threadId'] = $threadId;
		return new JsonModel($result);
	}
	
	public function get($id)
	{
	
	}
	
	public function create($data)
	{
		$dm = $this->documentManager();
		$resourceId = $data['resourceId'];
		$threadDoc = $dm->getRepository('Disqus\Document\Thread')->findOneBy(array('resourceId' => $resourceId));
		if($threadDoc == null) {
			$threadDoc = new Thread();
			$threadDoc->setTopic($data['topic']);
			$threadDoc->setResourceId($data['resourceId']);
			
			$dm->persist($threadDoc);
			$dm->flush();
		}
		$threadId = $threadDoc->getId();
		$postDoc = new Post();
		$postDoc->setFromArray($data);
		$postDoc->setThreadId($threadId);
		$postDoc->setCreated(new \MongoDate());
		
		$dm->persist($postDoc);
		$dm->flush();
		
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		return new JsonModel($postDoc->toArray());
	}
	
	public function update($id, $data)
	{
	
	}
	
	public function delete($id)
	{
		
	}
}