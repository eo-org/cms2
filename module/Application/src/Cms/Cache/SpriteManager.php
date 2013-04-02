<?php
namespace Cms\Cache;

class SpriteManager
{
	public $storage;
	
	public $skipUpdate = false;
	
	protected $key;
	
	public function __construct($storage, $sm)
	{
		$this->storage = $storage;
	}
	
	public function save($cacheContent)
	{
		if($this->skipUpdate) {
			return;
		}
		
		$key = $this->getKey();
		$this->storage->setItem($key, $cacheContent);
	}
	
	public function load()
	{
		if(!$this->shouldCache()) {
			$this->skipUpdate = true;
			return null;
		}
		
		$key = $this->getKey();
		$success = false;
		$cacheDoc = $this->storage->getItem($key, $success);
		if($success) {
			$this->skipUpdate = true;
			return $cacheDoc->getContent();
		}
		return null;
	}
	
	public function getKey()
	{
		return 'sprite-head-tail';
	}
	
	public function shouldCache()
	{
		return true;
	}
}