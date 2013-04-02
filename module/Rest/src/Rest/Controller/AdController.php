<?php
namespace Rest\Controller;

use MongoId;
use MongoRegex;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Json\Json;
use Zend\View\Model\JsonModel;

class AdController extends AbstractRestfulController 
{
	public function getList()
	{
		$sectionId = $this->getRequest()->getHeader('X-Section-Id')->getFieldValue();
		if(is_null($sectionId)) {
			throw new Exception('section id is null');
		}
		
		$factory = $this->dbFactory();
		$co = $factory->_m('Ad');
		$data = $co->addFilter('sectionId', $sectionId)
			->addSort('sort', 1)
			->fetchArr(false);
		return new JsonModel($data);
	}
	
	public function get($id)
	{
		
	}
	
	public function create($data)
	{
		$sectionId = $this->getRequest()->getHeader('X-Section-Id')->getFieldValue();
		
		$factory = $this->dbFactory();
		$sectionDoc = $factory->_m('Ad_Section')
			->find($sectionId);
		if(is_null($sectionDoc)) {
			throw new Exception('section doc not found with id:'.$sectionId);
		}
		
		$dataStr = $data['model'];
		$dataArr = Json::decode($dataStr);
		
		$doc = $factory->_m('Ad')->create();
		$doc->setFromArray($dataArr);
		$doc->sectionId = $sectionId;
		$doc->save();
		$sectionDoc->updatePreview();
		
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		return new JsonModel(array(
			'id' => $doc->getId()
		));
	}
	
	public function update($id, $data)
	{
		$dataStr = $data['model'];
		$dataArr = Json::decode($dataStr);
		
		$factory = $this->dbFactory();
		$co = $factory->_m('Ad');
		$doc = $co->find($id);
		$doc->setFromArray($dataArr);
		$doc->save();
		
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		return array('id' => $id);		
	}
	
	public function delete($id)
	{
		$factory = $this->dbFactory();
		$co = $factory->_m('Ad');
		$doc = $co->find($id);
		$doc->delete();
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
	}
}