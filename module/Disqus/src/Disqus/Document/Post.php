<?php
namespace Disqus\Document;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="disqus_post"
 * )
 * 
 * */
class Post extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;
	
	/** @ODM\Field(type="string")  */
	protected $threadId;
	
	/** @ODM\Field(type="string")  */
	protected $userId;
	
	/** @ODM\Field(type="string")  */
	protected $userName;
	
	/** @ODM\Field(type="string")  */
	protected $topic;
	
	/** @ODM\Field(type="string")  */
	protected $content;
	
	/** @ODM\Field(type="date")  */
	protected $created;
}