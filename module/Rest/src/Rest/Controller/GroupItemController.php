<?php
namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Json\Json;
use Zend\View\Model\JsonModel;

class GroupItemController extends AbstractRestfulController
{
	public function getList()
	{
		$treeType = $this->getRequest()->getHeader('X-Tree-Type')->getFieldValue();
		$treeId = $this->getRequest()->getHeader('X-Tree-Id')->getFieldValue();
		$factory = $this->dbFactory();
		
		$co = $factory->_m('Group_Item')
			->addFilter('groupType', $treeId)
			->setFields(array('label', 'alias', 'layoutAlias', 'parentId', 'className', 'iconName', 'bannerName', 'sort', 'disabled', 'groupType'));
				
		$data = $co->addSort('sort', 1)
			->addSort('_id', -1)
			->fetchAll(true);
		
		return new JsonModel($data);
	}
	
	public function get($id)
	{
		
	}
	
	public function create($data)
	{
		$treeType = $this->getRequest()->getHeader('X-Tree-Type')->getFieldValue();
		$treeId = $this->getRequest()->getHeader('X-Tree-Id')->getFieldValue();
		
		$factory = $this->dbFactory();
		
		$co = $factory->_m('Group_Item');
		$doc = $co->create();
		$doc->groupType = $treeId;
				
		$dataStr = $data['model'];
		$dataArr = Json::decode($dataStr, Json::TYPE_ARRAY);
		
		$doc->setFromArray($dataArr);
		$doc->save();
		
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		return new JsonModel(array('id' => $doc->getId()));
	}
	
	public function update($id, $data)
	{
		$treeType = $this->getRequest()->getHeader('X-Tree-Type')->getFieldValue();
		
		$factory = $this->dbFactory();
		$co = $factory->_m('Group_Item');
		
		$doc = $co->find($id);
		$dataStr = $data['model'];
		$dataArr = Json::decode($dataStr, Json::TYPE_ARRAY);
		$doc->setFromArray($dataArr);
		$doc->save();
		
		$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		return new JsonModel(array('id' => $id));
	}
	
	public function delete($id)
	{
		$treeType = $this->getRequest()->getHeader('X-Tree-Type')->getFieldValue();
		
		$factory = $this->dbFactory();
		$co = $factory->_m('Group_Item');
		
		$childDoc = $co->addFilter('parentId', $id)
			->fetchOne();
		if(is_null($childDoc)) {
			$doc = $co->find($id);
			$doc->delete();
			$this->getResponse()->getHeaders()->addHeaderLine('result', 'sucess');
		} else {
			$this->getResponse()->getHeaders()->addHeaderLine('result', 'fail');
			echo "不能删除非空的节点！";
		}
		return new JsonModel(array('id' => $id));
	}
}