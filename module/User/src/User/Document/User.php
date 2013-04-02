<?php
namespace User\Document;

use Zend\InputFilter\Factory as FilterFactory, Zend\InputFilter\InputFilter;
use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="user_user"
 * )
 * 
 * */
class User extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;
	
	/** @ODM\Field(type="string")  */
	protected $email;
	
	/** @ODM\Field(type="string")  */
	protected $password;
	
	/** @ODM\Field(type="string")  */
	protected $userGroup = 'online';
	
	/** @ODM\Field(type="string")  */
	protected $status = 'active';
	
	/** @ODM\Field(type="hash")  */
	protected $attributeList;
	
	/** @ODM\Field(type="date")  */
	protected $created;
	
	protected $inputFilter;
	
	public function getInputFilter()
	{
		if(!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$inputFactory = new FilterFactory();
			
			$inputFilter->add($inputFactory->createInput(array(
				'name'		=> 'email',
				'requried'	=> true,
				'filters'	=> array(
					array('name' => 'StringTrim')
				),
				'validators' => array(
					array('name' => 'EmailAddress')
				)
			)));
			$inputFilter->add($inputFactory->createInput(array(
				'name'		=> 'password',
				'requried'	=> true,
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 6,
							'max'      => 18,
						)
					)
				)
			)));
			$inputFilter->add($inputFactory->createInput(array(
				'name'		=> 'userGroup',
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
        $this->email = $data['email'];
        $this->password  = $data['password'];
        $this->userGroup = $data['userGroup'];
        $this->status = $data['status'];
    }
    
    public function getArrayCopy()
    {
    	return array(
    		'id' => $this->id,
    		'email'	=> $this->email,
    		'password' => $this->password,
    		'userGroup' => $this->userGroup,
    		'status' => $this->status
    	);
    }
}