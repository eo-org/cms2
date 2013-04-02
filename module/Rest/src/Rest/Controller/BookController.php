<?php
namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Json\Json;
use Zend\View\Model\JsonModel;

class BookController extends AbstractRestfulController
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
		$co = $factory->_m('Book');
		$co->setFields(array('label', 'alias'));
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
					case 'label':
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
		$treeId = $id;
		$jsonStr = $data['sortJsonStr'];
		$pageObj = Json::decode($jsonStr);
		 
		$factory = $this->dbFactory();
		$co = $factory->_m('Book_Page');
		$docs = $co->setFields(array('label', 'parentId', 'sort', 'alias'))
			->addFilter('bookId', $treeId)
			->sort('sort', 1)
			->fetchDoc();
		foreach($docs as $doc) {
			$pageId = $doc->getId();
			$newPageValue = $pageObj->$pageId;
			$sort = intval($newPageValue->sort);
			$parentId = $newPageValue->parentId;
			if($doc->sort != $sort || $doc->parentId != $parentId) {
				$doc->sort = $sort;
				$doc->parentId = $parentId;
				$doc->save();
			}
		}
		 
		$treeDoc = $factory->_m('Book')->find($treeId);
		$treeDoc->setLeafs($docs);
		$treeIndex = $treeDoc->buildIndex();
		$treeDoc->bookIndex = $treeIndex;
		$treeDoc->save();
		 
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		return new JsonModel(array('id' => $treeId));
	}
	
	public function delete($id)
	{
		
	}
	
	public function treeSortAction()
	{
		
	}
}