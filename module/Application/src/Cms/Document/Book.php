<?php
namespace Cms\Document;

use Core\Document\TreeDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="book"
 * )
 * 
 * */
class Book extends TreeDocument
{
	/** @ODM\Id */
	protected $id;

	/** @ODM\Field(type="string") */
	protected $label;

	/** @ODM\Field(type="string") */
	protected $alias;
	
	/** @ODM\Field(type="string") */
	protected $layoutAlias;
	
	/** @ODM\Field(type="string") */
	protected $description;
	
	/** @ODM\Field(type="hash") */
	protected $bookIndex;
	
	protected function _getIndex()
	{
		return $this->bookIndex;
	}
	
	protected function _getReadLeafCollection()
	{
		$dm = self::$objectManager;
		$bookPages = $dm->getRepository('Cms\Document\Book\Page')->findByBookId($this->getId());
		return $bookPages;
	}
	
	public function getTrail($id)
	{
		if(is_null($this->_trail)) {
			$this->_trail[0] = $this->getArrayCopy();
			$index = $this->_getIndex();
	
			$this->_searchChildren($this->_trail, $id, $index, 0);
			ksort($this->_trail);
		}
			
		return $this->_trail;
	}
	
	public function getArrayCopy()
	{
		return array(
			'id' => $this->id,
			'label' => $this->label,
			'alias' => $this->alias,
			'layoutAlias' => $this->layoutAlias,
			'description' => $this->description
		);
	}
}