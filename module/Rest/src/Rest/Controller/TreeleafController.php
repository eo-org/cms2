<?php
namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Json\Json;
use Zend\View\Model\JsonModel;

class TreeleafController extends AbstractRestfulController
{
	public function getList()
	{
		$treeType = $this->getRequest()->getHeader('X-Tree-Type')->getFieldValue();
		$treeId = $this->getRequest()->getHeader('X-Tree-Id')->getFieldValue();
		$factory = $this->dbFactory();
		switch($treeType) {
			case 'navi':
				$co = $factory->_m('Navi_Link')
					->addFilter('naviId', $treeId)
					->setFields(array('label', 'link', 'parentId', 'className', 'sort', 'description', 'resourceId'));
				break;
			case 'book':
				$co = $factory->_m('Book_Page')
					->addFilter('bookId', $treeId)
					->setFields(array('label', 'alias', 'parentId', 'sort'));
				break;
			case 'group':
				$co = $factory->_m('Group_Item')
					->addFilter('groupType', $treeId)
					->setFields(array('label', 'alias', 'layoutAlias', 'parentId', 'className', 'iconName', 'bannerName', 'sort', 'disabled', 'groupType'));
				break;
		}
		
		$data = $co->addSort('sort', 1)
			->addSort('_id', -1)
			->fetchAll(true);
		
		return new JsonModel($data);
	}
	
	public function get($id)
	{
		$co = $factory->_m('Book_Page');
		$data = $co->setFields(array('label', 'link', 'parentId', 'sort'))
			->sort('sort', 1)
			->fetchAll(true);
        return new JsonModel($data);
	}
	
	public function create($data)
	{
		$treeType = $this->getRequest()->getHeader('X-Tree-Type')->getFieldValue();
		$treeId = $this->getRequest()->getHeader('X-Tree-Id')->getFieldValue();
		
		$factory = $this->dbFactory();
		switch($treeType) {
			case 'navi':
				$co = $factory->_m('Navi_Link');
				$doc = $co->create();
				$doc->naviId = $treeId;
				break;
			case 'book':
				$co = $factory->_m('Book_Page');
				$doc = $co->create();
				$doc->bookId = $treeId;
				break;
			case 'group':
				$co = $factory->_m('Group_Item');
				$doc = $co->create();
				$doc->groupType = $treeId;
				break;
		}
		
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
		switch($treeType) {
			case 'navi':
				$co = $factory->_m('Navi_Link');
				break;
			case 'book':
				$co = $factory->_m('Book_Page');
				break;
			case 'group':
				$co = $factory->_m('Group_Item');
				break;
		}
		
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
		switch($treeType) {
			case 'navi':
				$co = $factory->_m('Navi_Link');
				break;
			case 'book':
				$co = $factory->_m('Book_Page');
				break;
			case 'group':
				$co = $factory->_m('Group_Item');
				break;
		}
		
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