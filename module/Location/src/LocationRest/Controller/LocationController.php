<?php
namespace LocationRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Location\Document\Location;
use Zend\View\Model\JsonModel;

class LocationController extends AbstractRestfulController
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
		$qb = $dm->createQueryBuilder('Location\Document\Location');
		$cursor = $qb->limit($pageSize)->skip($skip)
			->sort('provinceId', 1)
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
		$countyId = $data['countyId'];
		$prefixArr = $this->getFullAddressPrefix($countyId);
		
		$data['provinceName'] = $prefixArr['provinceName'];
		$data['cityName'] = $prefixArr['cityName'];
		$data['countyName'] = $prefixArr['countyName'];
		$data['fullAddress'] = $prefixArr['pccName'].$data['addressDetail'];
		
 		$locationDoc = new Location();
 		$locationDoc->exchangeArray($data);
 		$dm = $this->documentManager();
 		$dm->persist($locationDoc);
 		$dm->flush();
		
 		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		return new JsonModel($locationDoc->getArrayCopy());
	}
	
	public function update($id, $data)
	{
	
	}
	
	public function delete($id)
	{
		
	}
	
	public function getFullAddressPrefix($countyId)
	{
		$config = $this->getServiceLocator()->get('Config');
		$apiHost = $config['api']['host'];
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiHost.'/rest/address/'.$countyId);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		
		$jsonObj = json_decode($output);
		return array(
			'provinceName' => $jsonObj->Data->provinceName,
			'cityName' => $jsonObj->Data->cityName,
			'countyName' => $jsonObj->Data->countyName,
			'pccName' => $jsonObj->Data->pccName
		);
	}
}