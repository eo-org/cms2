<?php
namespace Cms\Document\Book;

use Core\Document\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="book_page"
 * )
 * 
 * */
class Page extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;

	/** @ODM\Field(type="string") */
	protected $bookId;
	
	/** @ODM\Field(type="string") */
	protected $label;

	/** @ODM\Field(type="string") */
	protected $fulltext;
	
	/** @ODM\Field(type="string") */
	protected $alias;
	
	/** @ODM\Field(type="date")  */
	protected $created;
	
	/** @ODM\Field(type="date")  */
	protected $updated;
	
	/** @ODM\Field(type="string") */
	protected $editor;
	
	public function getArrayCopy()
	{
		return array(
			'id' => $this->id,
			'bookId' => $this->bookId,
			'label' => $this->label,
			'fulltext' => $this->fulltext,
			'alias' => $this->alias,
			'created' => $this->created,
			'updated' => $this->updated,
			'editor' => $this->editor
		);
	}
}