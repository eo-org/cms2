<?php
namespace User\Document;

use Zend\InputFilter\Factory as FilterFactory, Zend\InputFilter\InputFilter;
use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="user_group"
 * )
 * 
 * */
class UserGroup extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;
	
	/** @ODM\Field(type="string")  */
	protected $label;
	
	protected $inputFilter;
	
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
        $this->label = $data['label'];
    }
    
    public function getArrayCopy()
    {
    	return array(
    		'id' => $this->id,
    		'label'	=> $this->label
    	);
    }
}