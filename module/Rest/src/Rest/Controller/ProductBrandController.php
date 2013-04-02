<?php
namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Json\Json;
use Zend\View\Model\JsonModel;

class ProductBrandController extends AbstractRestfulController
{
	public function getList()
	{	
		$filter = $this->getRequest()->getQuery(); 
		
		$currentPage = $filter['page'];
		$sIndex = $filter['sIndex'];
		$sOrder = intval($filter['sOrder']);
		$qGroup = $filter['qGroup'];
		$queryStr = $filter['query'];
		
		$pageSize = 20;
		if(empty($currentPage)) {
			$currentPage = 1;
		}
		
		$skip = $pageSize * ($currentPage - 1);
		
		$dm = $this->documentManager();
		$qb = $dm->createQueryBuilder('Cms\Document\Product\Brand');
		
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
		$attributesetId = $this->getRequest()->getHeader('X-Attributeset-Id')->getFieldValue();
		$dataStr = $data['model'];
		$dataArr = Json::decode($dataStr, Json::TYPE_ARRAY);
		
		$dm = $this->documentManager();
		$attributesetDoc = $dm->getRepository('Cms\Document\Attributeset')->findOneById($attributesetId);
		$attributeDoc = $attributesetDoc->createAttribute();
		$attributeDoc->exchangeArray($dataArr);
		$attributeDoc->setAttributesetId($attributesetId);
		$attributesetDoc->addAttribute($attributeDoc);
		$dm->persist($attributesetDoc);
		$dm->flush();
		
		return new JsonModel(array('id' => $attributeDoc->getId()));
	}
	
	public function update($id, $data)
	{
		$attributesetId = $this->getRequest()->getHeader('X-Attributeset-Id')->getFieldValue();
		$dataStr = $data['model'];
		$dataArr = Json::decode($dataStr, Json::TYPE_ARRAY);
		
		$dm = $this->documentManager();
		$attributeDoc = $dm->getRepository('Cms\Document\Attribute')->findOneById($id);
		$attributeDoc->exchangeArray($dataArr);
		$dm->persist($attributeDoc);
		$dm->flush();
		
		return new JsonModel(array('id' => $attributeDoc->getId()));
	}
	
	public function delete($id)
	{
		$attributesetId = $this->getRequest()->getHeader('X-Attributeset-Id')->getFieldValue();
		$dm = $this->documentManager();
		$attributesetDoc = $dm->getRepository('Cms\Document\Attributeset')->findOneById($attributesetId);
		$attributesetDoc->removeAttribute($id);
		$dm->persist($attributesetDoc);
		$dm->flush();
		return new JsonModel(array('id' => $id));
	}
}