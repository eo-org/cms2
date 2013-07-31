<?php
namespace LocationRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use User\Document\User;
use Zend\View\Model\JsonModel;

class LocationController extends AbstractRestfulController
{
	public function getList()
	{
		return new JsonModel(array('name' => 'empty'));
	}
	
	public function get($id)
	{
	
	}
	
	public function create($data)
	{
		$countyId = $data['countyId'];
		//$fullAddressPrefix = $this->getFullAddressPrefix($countyId);
		$data['fullAddress'] = $fullAddressPrefix.$data['addressDetail'];
		print_r($data);
// 		$locationDoc = new Location();
// 		$locationDoc->exchangeArray($data);
// 		$dm = $this->documentManager();
// 		$dm->persist($locationDoc);
// 		$dm->flush();
		
// 		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
// 		return $locationDoc->getArrayCopy();

		return new JsonModel($locationDoc->getArrayCopy());
	}
	
	public function update($id, $data)
	{
	
	}
	
	public function delete($id)
	{
		
	}
	
	public function getFullAddress($countyId)
	{
		curl_init();
	}
}