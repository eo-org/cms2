<?php
namespace Message\Document;

use Zend\InputFilter\Factory as FilterFactory, Zend\InputFilter\InputFilter;
use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Message\Document\MessageForm;

/** 
 * @ODM\Document(
 * 		collection="message_post"
 * )
 * 
 * */
class Post extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;
	
	/** @ODM\Field(type="string")  */
	protected $formId;
	
	/** @ODM\Field(type="hash")  */
	protected $content;
	
	/** @ODM\Field(type="date")  */
	protected $created;
	
	/** @ODM\Field(type="date")  */
	protected $modified;
	
	public function exchangeArray($data)
	{	
		$this->formId = $data['formId'];
		
		$this->content = $data['postContent'];
		
		if($this->created === null) {
			$this->created = new \DateTime();
		}
		
		$this->modified = new \DateTime();
	}
	
	public function getArrayCopy()
	{	
		return array(
			'formId' => $this->formId,
			'content' => $this->content,
			'created' => $this->created,
			'modified' => $this->modified,
		);
	}
	
	public function render()
	{
		$LIs = "";
		foreach($this->elements as $element) {
			$LIs.= $element->render();
		}
		return $LIs;
	}
}