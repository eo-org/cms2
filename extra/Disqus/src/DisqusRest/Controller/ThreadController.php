<?php
namespace DisqusRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Disqus\Document\Thread,
Disqus\Document\Post;

class ThreadController extends AbstractRestfulController
{
	public function getList()
	{
		$filter = $this->getRequest()->getQuery();
		$urlMd5 = $filter['urlMd5'];
		
		$currentPage = $filter['page'];
		if(empty($currentPage)) {
			$currentPage = 1;
		}
		$pageSize = 100;
		$skip = $pageSize * ($currentPage - 1);
		
		$dm = $this->documentManager();
		$qb = $dm->createQueryBuilder('Disqus\Document\Thread');
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
		return new JsonModel($result);
	}
	
	public function get($id)
	{
	
	}
	
	public function create($data)
	{
		$postDoc = new Post();
		$postDoc->setFromArray($data);
		$postDoc->setCreated(new \MongoDate());
		$dm = $this->documentManager();
		$dm->persist($postDoc);
		$dm->flush();
		
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		return $postDoc->toArray();
	}
	
	public function update($id, $data)
	{
	
	}
	
	public function delete($id)
	{
		
	}
}