<?php
namespace Ext\Document;

use Zend\InputFilter\Factory as FilterFactory, Zend\InputFilter\InputFilter;
use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="brick_template"
 * )
 * @ODM\Index(keys={"extName"="asc"})
 * */
class Template extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;

	/** @ODM\Field(type="string") */
	protected $extName;
	
	/** @ODM\Field(type="string") */
	protected $scriptName;
	
	/** @ODM\Field(type="string")  */
	protected $content;
	
	protected $inputFilter;
	
	public function getInputFilter()
	{
		if(!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$inputFactory = new FilterFactory();
			
			$dm = $this->getObjectManager();
			$inputFilter->add($inputFactory->createInput(array(
				'name'		=> 'scriptName',
				'requried'	=> true,
				'filters'	=> array(
					array('name' => 'StringTrim')
				),
				'validators' => array(
					array('name' => 'Regex', 'options' => array('pattern' => '/^[a-z]*$/'))
				)
			)));
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
	
	public function getArrayCopy()
	{
		return array(
			'id' => $this->id,
			'extName' => $this->extName,
			'scriptName' => $this->scriptName,
			'content'	=> $this->content
		);
	}
}