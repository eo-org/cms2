<?php
namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Json\Json;
use Zend\View\Model\JsonModel;

class HeadFileController extends AbstractRestfulController
{
	public function getList()
	{
		$factory = $this->dbFactory();
		$co = $factory->_m('HeadFile');
		$data = $co->fetchAll(true);
		return new JsonModel($data);
	}
	
	public function get($id)
	{

	}
	
	public function create($data)
	{
		$dataStr = $data['model'];
		$dataArr = Json::decode($dataStr);
		
		$factory = $this->dbFactory();
		$doc = $factory->_m('HeadFile')->create();
		$doc->setFromArray($dataArr);
		$doc->save();
		
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		return array('id' => $doc->getId());		
	}
	
	public function update($id, $data)
	{
		$dataStr = $data['model'];
		$dataArr = Json::decode($dataStr);
		
		$factory = $this->dbFactory();
		$co = $factory->_m('HeadFile');
		$doc = $co->find($id);
		$doc->setFromArray($dataArr);
		$doc->save();
		
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		return array('id' => $id);
	}
	
	public function delete($id)
	{
		$factory = $this->dbFactory();
		$co = $factory->_m('HeadFile');
		$doc = $co->find($id);
		$doc->delete();
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
	}
}