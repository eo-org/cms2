<?php
namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Json\Json;
use Zend\View\Model\JsonModel;

class GroupController extends AbstractRestfulController
{
    public function getList()
    {
    	
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
    	$childArr = Json::decode($jsonStr, Json::TYPE_ARRAY);
    	 
    	$factory = $this->dbFactory();
    	$co = $factory->_m('Group_Item');
    	$docs = $co->setFields(array('label', 'parentId', 'sort', 'alias', 'layoutAlias', 'className', 'iconName', 'bannerName', 'disabled'))
	    	->addFilter('groupType', $treeId)
	    	->sort('sort', 1)
	    	->fetchDoc();
    	foreach($docs as $doc) {
    		$childId = $doc->getId();
    		if(isset($childArr[$childId])) {
    			$newChildValue = $childArr[$childId];
    		} else {
    			$newChildValue = array('sort' => 0, 'parentId' => 1);
    		}
    		$sort = intval($newChildValue['sort']);
    		$parentId = $newChildValue['parentId'];
    		if($doc->sort != $sort || $doc->parentId != $parentId) {
    			$doc->sort = $sort;
    			$doc->parentId = $parentId;
    			$doc->save();
    		}
    	}
    	 
    	if($treeId == 'article') {
    		$treeDoc = $factory->_m('Group')->findArticleGroup();
    	} else if($treeId == 'product') {
    		$treeDoc = $factory->_m('Group')->findProductGroup();
    	}
    	$treeDoc->setLeafs($docs);
    	$treeIndex = $treeDoc->buildIndex();
    	$treeDoc->groupIndex = $treeIndex;
    	$treeDoc->save();
    	 
    	$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		return new JsonModel(array('id' => $treeId));
    }
    
    public function delete($id)
    {
    	
    }
}