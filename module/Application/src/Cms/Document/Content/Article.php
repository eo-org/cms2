<?php
class Class_Mongo_Article_Doc extends App_Mongo_Entity_Doc
{
	protected $_field = array(
			'groupId',
			'label',
			'link',
			'introtext',
			'metakey',
			'introicon',
			'fulltext',
			'created',
			'createdBy',
			'createdByAlias',
			'modified',
			'modifiedBy',
			'modifiedByAlias',
			'sort',
			'hits',
			'featured',
			'reference',
			'attachmentFiles',
			'status'
	);

	public function setAttachments($urlArr, $nameArr, $typeArr)
	{
		if(count($urlArr) != count($nameArr) || count($urlArr) != count($typeArr)) {
			throw new Exception('attachment count does not match each other!');
		}

		$attachment = array();
		foreach($typeArr as $key => $type) {
			$attachment[] = array('filetype' => $type, 'filename' => $nameArr[$key], 'urlname' => $urlArr[$key]);
		}
		$this->attachment = $attachment;
	}

	public function toggleTrash()
	{
		if($this->status == 'trash') {
			$this->status = 'publish';
		} else {
			$this->status = 'trash';
		}
		$this->save();
	}
}
























<?php
namespace Cms\Document\Content;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="article"
 * )
 * 
 * */
class Product extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;
	
	/** @ODM\Field(type="string")  */
	protected $attributesetId;
	
	/** @ODM\Field(type="string")  */
	protected $groupId;
	
	/** @ODM\Field(type="string")  */
	protected $label;
	
	/** @ODM\Field(type="string")  */
	protected $name;
	
	/** @ODM\Field(type="string")  */
	protected $sku;
	
	/** @ODM\Field(type="float")  */
	protected $price;
	
	/** @ODM\Field(type="string")  */
	protected $fulltext;
	
	/** @ODM\Field(type="string")  */
	protected $introicon;
	
	/** @ODM\Field(type="string")  */
	protected $introtext;
	
	/** @ODM\Field(type="string")  */
	protected $metakey;
	
	/** @ODM\Field(type="int")  */
	protected $weight;
	
	/** @ODM\Field(type="hash")  */
	protected $attachment;
	
	/** @ODM\Field(type="hash")  */
	protected $attributes;
	
	/** @ODM\Field(type="hash")  */
	protected $attributesLabel;
	
	/** @ODM\Field(type="string")  */
	protected $status = 'publish';
	
	/** @ODM\Field(type="date")  */
	protected $publishDate;
	
	/** @ODM\Field(type="date")  */
	protected $modified;
	
	/** @ODM\Field(type="date")  */
	protected $created;
	
	protected $attributesetDoc;
	
	public function setAttributesetDoc($attributesetDoc)
	{
		$this->attributesetDoc = $attributesetDoc;
		return $this;
	}
	
	public function clearAttachment()
	{
		$this->attachment = null;
	}
	
	public function setAttachment($urlArr, $nameArr, $typeArr)
	{
		if(count($urlArr) == 0) {
			return true;
		}
		if(count($urlArr) != count($nameArr) || count($urlArr) != count($typeArr)) {
			throw new Exception('attachment count does not match each other!');
		}

		$attachment = array();
		foreach($typeArr as $key => $type) {
			$attachment[] = array('filetype' => $type, 'filename' => $nameArr[$key], 'urlname' => $urlArr[$key]);
		}
		$this->attachment = $attachment;
	}

	public function toggleTrash()
	{
		if($this->status == 'trash') {
			$this->status = 'publish';
		} else {
			$this->status = 'trash';
		}
		$this->save();
	}
	
	public function exchangeArray($data)
	{
		$this->groupId = $data['groupId'];
		
		$this->label = $data['label'];
		
		$this->name = $data['name'];
		
		$this->sku = $data['sku'];
		
		$this->price = $data['price'];
		
		$this->fulltext = $data['fulltext'];
		
		$this->introicon = $data['introicon'];
		
		$this->introtext = $data['introtext'];
		
		$this->metakey = $data['metakey'];
		
		$this->weight = $data['weight'];
		
		$this->attributes = $data['attributes'];
		
		$this->attributesLabel = $this->setAttributesLabel();
		
		$this->status = $data['status'];
		
		$this->publishDate = new \DateTime($data['publishDate']);
	}
	
	public function getArrayCopy()
	{
		if(is_null($this->publishDate)) {
			$this->publishDate = new \DateTime();
		}
		return array(
				'groupId' => $this->groupId,
				'label' => $this->label,
				'name' => $this->name,
				'sku' => $this->sku,
				'price' => $this->price,
				'fulltext' => $this->fulltext,
				'introicon' => $this->introicon,
				'introtext' => $this->introtext,
				'metakey' => $this->metakey,
				'weight' => $this->weight,
				'status' => $this->status,
				'publishDate' => $this->publishDate->format('Y-m-d')
		);
	}
	
	public function timestamp($stamper)
	{
		$stamper->stamp($this);
	}
	
	private function setAttributesLabel()
	{
		if(is_null($this->attributesetDoc)) {
			return;
		}
		$labels = array();
		foreach($this->attributes as $attrCode => $optKey) {
			$attribute = $this->attributesetDoc->getAttributeByCode($attrCode);
			$fieldLabel = $attribute->getLabel();
			$valueLabel = $attribute->getOptionLabel($optKey);
			$labels[$attrCode] = array(
				'field' => $fieldLabel,
				'value' => $valueLabel
			);
		}
		return $labels;
	}
}