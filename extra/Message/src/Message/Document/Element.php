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
	
	public function render()
	{
		$LI = "";
		$HTML = "";
		if($this->type != 'section') {
			$HTML.= "<div class='messageform-element-label'>".
					"<label>$this->label</label>".
					"</div>";
			$HTML.= "<div class='messageform-element'>";
			switch($this->type) {
				case 'text':
					$HTML.= "<input id='messageform-element-$this->id' type='text' name='elements[$this->id]' value='' />";
					break;
				case 'textarea':
					$HTML.= "<textarea id='messageform-element-$this->id' name='elements[$this->id]'></textarea>";
					break;
				case 'select':
					$HTML.= "<select id='messageform-element-$this->id' name='elements[$this->id]'>";
					foreach($this->options as $op) {
						$HTML.= "<option value='".$op['code']."'>".$op['label']."</option>";
					}
					$HTML.= "</select>";
					break;
				case 'multicheckbox':
					foreach($this->getOptions() as $op) {
						$HTML.= "<input id='".$op['code']."' type='checkbox' name='elements[$this->id]' value='".$op['code']."' />";
						$HTML.= "<label for='".$op['code']."'>".$op['label']."</label>";
					}
					break;
				case 'radio':
					foreach($this->getOptions() as $op) {
						$HTML.= "<input id='".$op['code']."' type='radio' name='elements[$this->id]' value='".$op['code']."' />";
						$HTML.= "<label for='".$op['code']."'>".$op['label']."</label>";
					}
					break;
			}
			if(!empty($this->description)) {
				$HTML.= "<div class='messageform-element-desc'>$this->description</div>";
			}
		} else {
			$HTML.= "<div class='messageform-section'>$this->label</div>";
		}

		if(empty($this->classNames)) {
			$LI = "<li>$HTML</li>";
		} else {
			$LI = "<li class='$this->classNames'>$HTML</li>";
		}
		
		return $LI;
	}
}