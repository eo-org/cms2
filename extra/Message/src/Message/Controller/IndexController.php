<?php
namespace Message\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Disqus\Document\Thread,
Disqus\Document\Post;

class IndexController extends AbstractRestfulController
{
	public function getList()
	{
		
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