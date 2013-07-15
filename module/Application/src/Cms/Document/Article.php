<?php
namespace Cms\Document;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** 
 * @ODM\Document(
 * 		collection="article"
 * )
 * 
 * */
class Article extends AbstractDocument
{	
	/** @ODM\Id */
	protected $id;
	
	/** @ODM\Field(type="string")  */
	protected $groupId;
	
	/** @ODM\Field(type="string")  */
	protected $label;
	
	/** @ODM\Field(type="string")  */
	protected $fulltext;
	
	/** @ODM\Field(type="string")  */
	protected $introicon;
	
	/** @ODM\Field(type="string")  */
	protected $introtext;
	
	/** @ODM\Field(type="string")  */
	protected $metakey;
	
	/** @ODM\Field(type="hash")  */
	protected $attachment;
	
	/** @ODM\Field(type="string")  */
	protected $status = 'publish';
	
	/** @ODM\Field(type="date")  */
	protected $publishDate;
	
	/** @ODM\Field(type="date")  */
	protected $modified;
	
	/** @ODM\Field(type="string")  */
	protected $modifiedBy;
	
	/** @ODM\Field(type="string")  */
	protected $modifiedByAlias;
	
	/** @ODM\Field(type="date")  */
	protected $created;
	
	/** @ODM\Field(type="string")  */
	protected $createdBy;
	
	/** @ODM\Field(type="string")  */
	protected $createdByAlias;
	
	public function toggleTrash()
	{
		if($this->status == 'trash') {
			$this->status = 'publish';
		} else {
			$this->status = 'trash';
		}
		$this->save();
	}
	
	public function clearAttachment()
	{
		$this->attachment = null;
	}
	
	public function setAttachment($urlArr, $nameArr, $typeArr)
	{
		if(count($urlArr) == 0) {
			return true;
		}
		if(count($urlArr) != count($nameArr) || count($urlArr) != count($typeArr)) {
			throw new Exception('attachment count does not match each other!');
		}

		$attachment = array();
		foreach($typeArr as $key => $type) {
			$attachment[] = array('filetype' => $type, 'filename' => $nameArr[$key], 'urlname' => $urlArr[$key]);
		}
		$this->attachment = $attachment;
	}
	
	public function exchangeArray($data)
	{	
		$this->groupId = $data['groupId'];
		
		$this->label = $data['label'];
		
		$this->fulltext = $data['fulltext'];
		
		$this->introicon = $data['introicon'];
		
		$this->introtext = $data['introtext'];
		
		$this->metakey = $data['metakey'];
		
		$this->status = $data['status'];
		
		$this->publishDate = new \DateTime($data['publishDate']);
	}
	
	public function getArrayCopy()
	{
		if(is_null($this->publishDate)) {
			$this->publishDate = new \DateTime();
		}
		return array(
			'groupId' => $this->groupId,
			'label' => $this->label,
			'fulltext' => $this->fulltext,
			'introicon' => $this->introicon,
			'introtext' => $this->introtext,
			'metakey' => $this->metakey,
			'status' => $this->status,
			'publishDate' => $this->publishDate->format('Y-m-d')
		);
	}
	
	public function timestamp($stamper)
	{
		$stamper->stamp($this);
	}
}