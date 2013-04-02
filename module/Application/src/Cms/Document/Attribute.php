<?php
namespace Cms\Document;

use Core\AbstractDocument;
use Zend\Form\Element;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Cms\Form\Element\Brand;
/** 
 * @ODM\Document(
 * 		collection="attribute"
 * )
 * 
 * */
class Attribute extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;
	
	/** @ODM\Field(type="string")  */
	protected $attributesetId;
	
	/** @ODM\Field(type="string")  */
	protected $type;
	
	/** @ODM\Field(type="string")  */
	protected $UUID;
	
	/** @ODM\Field(type="string")  */
	protected $code;
	
	/** @ODM\Field(type="string")  */
	protected $label;
	
	/** @ODM\Field(type="string")  */
	protected $description;
	
	/** @ODM\Field(type="hash")  */
	protected $options;
	
	/** @ODM\Field(type="boolean")  */
	protected $required;
	
	/** @ODM\Field(type="int")  */
	protected $sort;
	
	public function getFormElement()
	{
		$element = null;
		switch($this->type) {
			case 'select':
				$element = new Element\Select($this->code);
				$element->setOptions(array('value_options' => $this->options));
				break;
			case 'text':
				$element = new Element\Text($this->code);
				break;
			case 'brand':
				$element = new Brand($this->code);
				$this->options = $element->loadValueOptions($this->attributesetId, self::getObjectManager());
				break;
			default:
				throw new \Exception($this->type.' is not defined');
		}
		$element->setLabel($this->label);
		return $element;
	}
	
	public function getOptions()
	{
		if($this->type == 'brand') {
			$element = new Brand($this->code);
			$this->options = $element->loadValueOptions($this->attributesetId, self::getObjectManager());
		}
		return $this->options;
	}
	
	public function getOptionLabel($optKey)
	{
		switch ($this->type) {
			case 'select':
			case 'brand':
				foreach($this->options as $key => $keyLabel) {
					if($optKey === $key) {
						return $keyLabel;
					}
				}
				break;
			case 'text':
				return $optKey;
		}
		return null;
	}
	
	public function exchangeArray($data)
	{
		$this->type = $data['type'];
		$this->UUID = $data['UUID'];
		$this->code = $data['code'];
		$this->label = $data['label'];
		$this->description = $data['description'];
		$this->required = $data['required'];
		$this->sort = $data['sort'];
		
		$options = array();
		if(isset($data['optionsCode'])) {
			foreach($data['optionsCode'] as $key => $code) {
				$options[$code] = $data['optionsLabel'][$key];
			}
		}
		$this->options = $options;
	}
	
	public function getArrayCopy()
	{
		return array(
			'id' => $this->id,
			'type' => $this->type,
			'UUID' => $this->UUID,
			'code' => $this->code,
			'label' => $this->label,
			'description' => $this->description,
			'options' => $this->options,
			'required' => $this->required,
			'sort' => $this->sort
		);
	}
}