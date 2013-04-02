<?php
namespace Cms\Document;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="twig_template"
 * )
 * @ODM\UniqueIndex(keys={"name"="asc"})
 * */
class Template extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;

	/** @ODM\Field(type="string") */
	protected $name;

	/** @ODM\Field(type="string")  */
	protected $content;
}