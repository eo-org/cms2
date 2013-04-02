<?php
namespace Ext\Document;

use Zend\InputFilter\Factory as FilterFactory, Zend\InputFilter\InputFilter;
use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="brick_cache"
 * )
 * @ODM\Index(keys={"brickId"="asc"})
 * */
class Cache extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;

	/** @ODM\Field(type="string") */
	protected $extName;
	
	/** @ODM\Field(type="string") */
	protected $brickId;
	
	/** @ODM\Field(type="string")  */
	protected $cachedContent;
	
	/** @ODM\Field(type="datetime")  */
	protected $updated;
}