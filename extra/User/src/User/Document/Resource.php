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
class Resource extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;
	
	/** @ODM\Field(type="string")  */
	protected $resourceId;
	
	/** @ODM\Field(type="hash")  */
	protected $allowedRoles;
}