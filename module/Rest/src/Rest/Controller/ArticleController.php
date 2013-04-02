<?php
namespace Rest\Controller;

use MongoRegex;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ArticleController extends AbstractRestfulController
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
		
		$factory = $this->getServiceLocator()->get('Core\Mongo\Factory');
		$co = $factory->_m('Article');
		$co->setFields(array('label', 'groupId', 'status'));
        $co->setPage($currentPage)->setPageSize($pageSize)
			->sort($sIndex, $sOrder);
		
		if($qGroup == 'all') {
			$co->addFilter('status', array('$ne' => 'trash'));
		} else {
			$co->addFilter('status', $qGroup);
		}
		
		if($queryStr != 'none') {
			$queryArr = explode('-', $queryStr);
			foreach($queryArr as $qItem) {
				list($key, $val) = explode(':', $qItem);
				switch($key) {
					case '_id':
						$co->addFilter('_id', new MongoID($val));
						break;
					case 'label':
						$co->addFilter($key, new MongoRegex("/".$val."/"));
						break;
					case 'groupId':
						$co->addFilter($key, $val);
						break;
				}
			}
		}
		
		$data = $co->fetchAll(true);
		$dataSize = $co->count();
		
		$dataGroupCount = $co->statusCount();
		
		$result = array();
		$result['data'] = $data;
        $result['dataSize'] = $dataSize;
        $result['pageSize'] = $pageSize;
        $result['currentPage'] = $currentPage;
		$result['groupCount'] = $dataGroupCount;
		
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
		$factory = $this->dbFactory();
		$co = $factory->_m('Article');
		$doc = $co->find($id);
		$doc->toggleTrash();
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
	}
}