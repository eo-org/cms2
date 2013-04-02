<?php
namespace Cms\Cache\Storage\Adapter;

use Zend\Cache\Storage\Adapter\AdapterOptions;

class MongoOptions extends AdapterOptions
{
	protected $collectionRepositoryName = 'Cms\Document\Cache';
	
	public function setRepositoryName($repository)
	{
		$this->collectionRepositoryName = $repository;
	}
	
	public function getRepositoryName()
	{
		return $this->collectionRepositoryName;
	}
}
