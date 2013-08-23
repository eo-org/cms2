<?php
namespace Disqus\Document;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="disqus_thread"
 * )
 * 
 * */
class Thread extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;
	
	/** @ODM\Field(type="string")  */
	protected $topic;
	
	/** @ODM\Field(type="string")  */
	protected $resourceId;
	
	/** @ODM\Field(type="date")  */
	protected $created;
}