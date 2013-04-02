<?php
namespace Cms\Document\Product;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\Form\Element;

/** 
 * @ODM\Document(
 * 		collection="cms_brand"
 * )
 * 
 * */
class Brand extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;
	
	/** @ODM\Field(type="hash")  */
	protected $attributesetId;
	
	/** @ODM\Field(type="string")  */
	protected $code;
	
	/** @ODM\Field(type="string")  */
	protected $label;
	
	/** @ODM\Field(type="string")  */
	protected $description;
	
	/** @ODM\Field(type="int")  */
	protected $sort;
	
	/** @ODM\Field(type="string")  */
	protected $category;
	
	
	public function exchangeArray($data)
	{
		$this->code = $data['code'];
		$this->label = $data['label'];
		$this->description = $data['description'];
		$this->sort = $data['sort'];
		$this->category = $data['category'];
	}
	
	public function getArrayCopy()
	{
		return array(
			'id' => $this->id,
			'attributesetId' => $this->attributesetId,
			'code' => $this->code,
			'label' => $this->label,
			'description' => $this->description,
			'sort' => $this->sort,
			'category' => $this->category
		);
	}
}