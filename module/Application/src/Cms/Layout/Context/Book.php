<?php
namespace Cms\Layout\Context;

use MongoId;
use Cms\Layout\ContextAbstract;

class Book extends ContextAbstract
{
	protected $shouldCache = true;
	
	protected $bookId;
	protected $bookDoc;
	protected $bookPageDoc;
	
	protected $trail = array();
	
	protected $bookLabel;
	
	public function init($bookAlias, $pageId, $presetLayoutDoc = null)
	{
		$dm = $this->getDocumentManager();
		
		$bookDoc = $dm->createQueryBuilder('Cms\Document\Book')->field('alias')->equals($bookAlias)
			->getQuery()
			->getSingleResult();
		
// 		$bookCo = $this->dbFactory->_m('Book');
// 		$bookDoc = $bookCo->addFilter('$or', array(
// 				array('_id' => new MongoId($bookId)),
// 				array('alias' => $bookId)
// 			))->fetchOne();
		
		if($bookDoc == null) {
			$this->bookId = 0;
			$layoutAlias = null;
			$this->trail = array();
		} else {
			$this->bookId = $bookDoc->getId();
			$this->bookLabel = $bookDoc->getLabel();
			$layoutAlias = $bookDoc->getLayoutAlias();
			
			if(is_null($pageId)) {
				$pageId = 'index';
			}
			
			$qb = $dm->createQueryBuilder('Cms\Document\Book\Page')
				->field('bookId')->equals($this->bookId);
			$qb->addOr($qb->expr()->field('_id')->equals($pageId))
				->addOr($qb->expr()->field('alias')->equals($pageId));
			
			$this->bookPageDoc = $qb->getQuery()
				->getSingleResult();
			if(is_null($this->bookPageDoc)) {
				throw new Cms\Exception\PageNotFoundException('book page not found with given id or alias: '.$pageId);
			}
			$pageId = $this->bookPageDoc->getId();
			$this->trail = $bookDoc->getTrail($pageId);
		}
		$this->bookDoc = $bookDoc;
		
		$layoutDoc = null;
		if(is_null($presetLayoutDoc)) {
			$layoutCo = $this->dbFactory->_m('Layout');
			if($layoutAlias != null) {
				//try to load by alias;
				$layoutDoc = $layoutCo->addFilter('type', 'book')
					->addFilter('alias', $layoutAlias)
					->fetchOne();
			}
			if($layoutDoc == null) {
				//load default
				$layoutDoc = $layoutCo->addFilter('type', 'book')
					->addFilter('default', 1)
					->fetchOne();
			}
			if($layoutDoc == null) {
				//create and load default
				$layoutDoc = $this->createDefaultLayout('book');
			}
		} else {
			$layoutDoc = $presetLayoutDoc;
		}
		
		$this->layoutDoc = $layoutDoc;
		$this->routeParams = array('id' => $bookAlias);
	}
	
	public function getContextDoc()
	{
		return $this->bookDoc;
	}
	
	public function getSubjectDoc()
	{
		return $this->bookPageDoc;
	}
	
	public function getId()
	{
		return $this->bookId;
	}
	
	public function getBreadcrumb()
	{
		return array();
	}
	
	public function getResourceId()
	{
		return $this->bookId;
	}
	
	public function getTitle()
	{
		return $this->bookLabel;
	}
	
	public function getType()
	{
		return "book";
	}
}