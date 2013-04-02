<?php
namespace Rest\Controller;

use Zend\View\Model\JsonModel;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Json\Json;

class LayoutController extends AbstractRestfulController
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
		
		$factory = $this->getServiceLocator()->get('Core\Mongo\Factory');
		$co = $factory->_m('Layout');
		$co->setFields(array('label', 'type', 'default'));
        $co->setPage($currentPage)->setPageSize($pageSize)
			->sort('default', -1);
		
		$data = $co->fetchAll(true);
		$dataSize = $co->count();
		
		$result = array();
		$result['data'] = $data;
        $result['dataSize'] = $dataSize;
        $result['pageSize'] = $pageSize;
        $result['currentPage'] = $currentPage;
		
		return $result;
    }
    
    public function get($id)
    {
    	
    }
    
	public function create($data)
    {
    	
    }
    
    public function update($id, $data)
    {
    	$layoutId = $id;
    	$jsonString = $data['jsonString'];
    	$jsonObj = Json::decode($jsonString, Json::TYPE_ARRAY);
    	$stagesObj = $jsonObj['stages'];
    	
    	$factory = $this->dbFactory();
    	$co = $factory->_m('Layout');
    	$doc = $co->find($layoutId);
    	if(is_null($doc)) {
    		$doc = $co->create();
    			
    	}
    	$oldStage = $doc->stage;
    	if(is_null($oldStage)) {
    		$oldStage = array();
    	}
    	$brickCo = $factory->_m('Brick');
    	foreach($oldStage as $v) {
    		$deleted = true;
    		foreach($stagesObj as $newValue) {
    			if($v['stageId'] == $newValue['stageId']) {
    				$deleted = false;
    				break;
    			}
    		}
    		if($deleted) {
    			$brickCo->delete(array('stageId' => $v['stageId']));
    		}
    	}
    	
    	$doc->stage = $stagesObj;
    	$doc->save();
    	
    	$this->getResponse()->getHeaders()->addHeaderLine('result', 'success');
    	return new JsonModel(array('layoutId' => $id));
    }
    
    public function delete($id)
    {
    	
    }
}