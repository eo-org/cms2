<?php
namespace User\Document;

use Zend\InputFilter\Factory as FilterFactory, Zend\InputFilter\InputFilter;
use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="user_config"
 * )
 * 
 * */
class Config extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;
	
	/** @ODM\Field(type="string")  */
	protected $acl = 'disable';
	
	/** @ODM\Field(type="hash")  */
	protected $protectedResourceId;
	
	protected $inputFilter;
	
	public function getInputFilter()
	{
		if(!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$inputFactory = new FilterFactory();
			
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
	
	public function exchangeArray($data)
    {
        $this->acl = $data['acl'];
        $this->protectedResourceId = $data['protectedResourceId'];
    }
    
    public function getArrayCopy()
    {
    	return array(
    		'id' => $this->id,
    		'acl' => $this->acl,
    		'protectedResourceId' => $this->protectedResourceId
    	);
    }
}