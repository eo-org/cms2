<?php
namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Json\Json;
use Zend\View\Model\JsonModel;

class AttributeController extends AbstractRestfulController
{
	public function getList()
	{
		$attributesetId = $this->getRequest()->getHeader('X-Attributeset-Id')->getFieldValue();
		$dm = $this->documentManager();
		$attributeDocs = $dm->getRepository('Cms\Document\Attribute')->findByAttributesetId($attributesetId);
		
		$data = array();
		foreach($attributeDocs as $attribute) {
			$data[] = $attribute->getArrayCopy();
		}
		
		return new JsonModel($data);
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