<?php
namespace Message\Document;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class Element extends AbstractDocument
{
	/** @ODM\Id(strategy="NONE") */
	protected $id;
	
	/** @ODM\Field(type="string")  */
	protected $type;
	
	/** @ODM\Field(type="string")  */
	protected $label;
	
	/** @ODM\Field(type="string")  */
	protected $description;
	
	/** @ODM\Field(type="collection")  */
	protected $options;
	
	/** @ODM\Field(type="boolean")  */
	protected $required;
	
	/** @ODM\Field(type="string")  */
	protected $sort;
	
	/** @ODM\Field(type="string")  */
	protected $classNames;
	
	public function exchangeArray($data)
	{
		$this->id = $data['id'];
		
		$this->type = $data['type'];
		
		$this->label = $data['label'];
	
		$this->description = $data['description'];
	
		$this->options = $data['options'];
		
		$this->required = $data['required'];
		
		$this->sort = $data['sort'];
		
		$this->classNames = $data['classNames'];
	}
	
	public function getArrayCopy()
	{
		return array(
			'id' => $this->id,
			'type' => $this->type,
			'label' => $this->label,
			'description' => $this->description,
			'options' => $this->options,
			'required' => $this->required,
			'sort' => $this->sort,
			'classNames' => $this->classNames
		);
	}
}