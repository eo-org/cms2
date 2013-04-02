<?php
namespace Cms\Document;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="cache"
 * )
 * @ODM\UniqueIndex(keys={"key"="asc"})
 * */
class Cache extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;

	/** @ODM\Field(type="string") */
	protected $key;

	/** @ODM\Field(type="string") */
	protected $type;
	
	/** @ODM\Field(type="date") */
	protected $updated;
	
	/** @ODM\Field(type="hash") */
	protected $content;
	
	public function setContent($content)
	{
		$this->content = $content;
	}
}