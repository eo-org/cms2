<?php
namespace Cms\Document\Brick;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="brick_template"
 * )
 * 
 * */
class Template extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;

	/** @ODM\Field(type="string") */
	protected $extName;

	/** @ODM\Field(type="string") */
	protected $sciptName;
	
	/** @ODM\Field(type="string") */
	protected $content;
	
	public function getArrayCopy()
	{
		return array(
			'id' => $this->id,
			'extName' => $this->extName,
			'sciptName' => $this->sciptName,
			'content' => $this->content
		);
	}
}