<?php
namespace DisqusRest\Controller;

use Zend\View\Model\JsonModel;

use Zend\Mvc\Controller\AbstractRestfulController;
use Disqus\Document\Thread,
Disqus\Document\Post;

class PostController extends AbstractRestfulController
{
	public function getList()
	{
		$threadId = $this->getRequest()->getHeader('X-Thread-Id')->getFieldValue();
		$filter = $this->getRequest()->getQuery();
		
		$dm = $this->documentManager();
		$qb = $dm->createQueryBuilder('Disqus\Document\Post');
		$cursor = $qb->field('threadId')->equals($threadId)
			->sort('_id', -1)
			->hydrate(false)
			->getQuery()
			->execute();
		$data = $this->formatData($cursor);
		return new JsonModel($data);
	}
	
	public function get($id)
	{
	
	}
	
	public function create($data)
	{
		
	}
	
	public function update($id, $data)
	{
	
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