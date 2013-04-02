<?php
namespace Rest\Controller;

use MongoId;
use MongoRegex;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Json\Json;
use Zend\View\Model\JsonModel;

class BrickController extends AbstractRestfulController
{
	public function getList()
	{
		$filter = $this->getRequest()->getQuery(); 
		
		$currentPage = $filter['page'];
		$sIndex = $filter['sIndex'];
		$sOrder = intval($filter['sOrder']);
		$queryStr = $filter['query'];
		
		$pageSize = 20;
		if(empty($currentPage)) {
			$currentPage = 1;
		}
		
		$factory = $this->dbFactory();
		$co = $factory->_m('Brick');
		$co->setFields(array('extName', 'brickName', 'cssSuffix', 'tplName'));
        $co->setPage($currentPage)->setPageSize($pageSize)
			->sort($sIndex, $sOrder);
		if($queryStr != 'none') {
			$queryArr = explode('-', $queryStr);
			foreach($queryArr as $qItem) {
				list($key, $val) = explode(':', $qItem);
				switch($key) {
					case '_id':
						$co->addFilter('_id', new MongoID($val));
						break;
					case 'extName':
						$co->addFilter($key, new MongoRegex("/".$val."/"));
						break;
					case 'brickName':
						$co->addFilter($key, new MongoRegex("/".$val."/"));
						break;
				}
			}
		}
		
		$data = $co->fetchAll(true);
		$dataSize = $co->count();
		
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
	
	}
	
	public function update($id, $data)
	{
	
	}
	
	public function delete($id)
	{
		
	}
}