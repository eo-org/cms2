<?php
namespace UserRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use User\Document\User;

class UserController extends AbstractRestfulController
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
		$qb = $dm->createQueryBuilder('User\Document\User');
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
		return $result;
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