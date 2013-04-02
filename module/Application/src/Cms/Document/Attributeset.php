<?php
namespace Cms\Document;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="attributeset"
 * )
 * 
 * */
class Attributeset extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;

	/** @ODM\Field(type="string")  */
	protected $type;
	
	/** @ODM\Field(type="string")  */
	protected $label;
	
	/** @ODM\ReferenceMany(cascade={"persist", "remove"})  */
	protected $attributeList = array();
	
	/** @ODM\Field(type="boolean")  */
	protected $isActive = true;
	
	public function getAttributeById($id)
	{
		foreach($this->attributeList as $attr) {
			if($attr->getId() == $id) {
				return $attr;
			}
		}
		return null;
	}
	
	public function getAttributeByCode($code)
	{
		foreach($this->attributeList as $attr) {
			if($attr->getCode() == $code) {
				return $attr;
			}
		}
		return null;
	}
	
	public function createAttribute()
	{
		return new Attribute();
	}
	
	public function addAttribute($attributeDocument)
	{
		$this->attributeList[] = $attributeDocument;
		return $this;
	}
	
	public function removeAttribute($id)
	{
		foreach($this->attributeList as $key => $attribute) {
			if($attribute->getId() == $id) {
				unset($this->attributeList[$key]);
			}
		}
		return false;
	}
	
	public function exchangeArray($data)
	{
		$this->label = $data['label'];
	}
}