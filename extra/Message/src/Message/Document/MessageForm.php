<?php
namespace Message\Document;

use Zend\InputFilter\Factory as FilterFactory, Zend\InputFilter\InputFilter;
use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Message\Document\Element;

/** 
 * @ODM\Document(
 * 		collection="message_messageform"
 * )
 * 
 * */
class MessageForm extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;
	
	/** @ODM\EmbedMany(targetDocument="Message\Document\Element")  */
	public $elements = array();
	
	/** @ODM\Field(type="string")  */
	protected $label;
	
	/** @ODM\Field(type="string")  */
	protected $description;
	
	/** @ODM\Field(type="string")  */
	protected $confirmationOption;
	
	/** @ODM\Field(type="string")  */
	protected $confirmationText;
	
	/** @ODM\Field(type="string")  */
	protected $confirmationRedirectUrl;
	
	/** @ODM\Field(type="string")  */
	protected $confirmationEmail;
	
	/** @ODM\Field(type="date")  */
	protected $created;
	
	/** @ODM\Field(type="date")  */
	protected $modified;
	
	protected $inputFilter;
	
	public function setElements($elements)
	{
		$this->elements = $elements;
		return $this;
	}
	
	public function getInputFilter()
	{
		if(!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$inputFactory = new FilterFactory();
			
			$inputFilter->add($inputFactory->createInput(array(
				'name'		=> 'label',
				'requried'	=> true,
				'filters'	=> array(
					array('name' => 'StringTrim')
				),
			)));
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
	
	public function exchangeArray($data)
	{
		$elementDocs = array();
		$elementsArr = $data['elements'];
		
		foreach($elementsArr as $key => $elementData) {
			$elementDoc = new Element();
			$elementDoc->exchangeArray($elementData);
			$elementDoc->setSort($key + 1);
			$elementDocs[] = $elementDoc;
		}
		$this->elements = $elementDocs;
		
		$this->label = $data['label'];
		
		$this->description = $data['description'];
		
		$this->confirmationOption = empty($data['confirmationOption']) ? 'text' : $data['confirmationOption'];
		
		$this->confirmationText = empty($data['confirmationText']) ? '您的消息已提交！' : $data['confirmationText'];
		
		$this->confirmationRedirectUrl = empty($data['confirmationRedirectUrl']) ? "" : $data['confirmationRedirectUrl'];
		
		$this->confirmationEmail = "";
		
		if($this->created === null) {
			$this->created = new \DateTime();
		}
		
		$this->modified = new \DateTime();
	}
	
	public function getArrayCopy()
	{
		$elementArr = array();
		foreach($this->elements as $el) {
			$elementArr[] = $el->getArrayCopy();
		}
		
		return array(
			'elements'					=> $elementArr,
			'label'						=> $this->label,
			'description'				=> $this->description,
			'confirmationOption'		=> $this->confirmationOption,
			'confirmationText'			=> empty($this->confirmationText) ? '您的消息已提交！' : $this->confirmationText,
			'confirmationRedirectUrl'	=> $this->confirmationRedirectUrl,
			'confirmationEmail'			=> $this->confirmationEmail,
			'created'					=> $this->created,
			'modified'					=> $this->modified,
		);
	}
	
	public function buildPostArr($postData)
	{
		$postContent = array();
		foreach($postData as $elKey => $pd) {
			$targetEl = null;
			foreach($this->elements as $element) {
				if($elKey == $element->getId()) {
					$targetEl = $element;
				}
			}
			
			if(!is_null($targetEl)) {
				$postContent[$elKey] = array(
					'fieldLabel' => $targetEl->getLabel(),
					'fieldType' => $targetEl->getType(),
					'optVal' => $pd
				);
			}
		}
		return array(
			'formId' => $this->getId(),
			'postContent' => $postContent
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