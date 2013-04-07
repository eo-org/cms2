<?php
namespace Cms\Document;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="book"
 * )
 * 
 * */
class Book extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;

	/** @ODM\Field(type="string") */
	protected $label;

	/** @ODM\Field(type="string") */
	protected $alias;
	
	/** @ODM\Field(type="string") */
	protected $layoutAlias;
	
	/** @ODM\Field(type="string") */
	protected $description;
	
	/** @ODM\Field(type="hash") */
	protected $bookIndex;
}