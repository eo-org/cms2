<?php
namespace Cms\Cache;

use Fucms\Session\Admin as SessionAdmin;

class Manager
{
	public $storage;
	public $context;
	
	public $skipUpdate = false;
	
	protected $key;
	//3600 * 3 = 10800
	protected $ttl = 10800;
	
	public function __construct($storage, $context)
	{
		$this->storage = $storage;
		$this->context = $context;
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
			$updated = $cacheDoc->getUpdated();
			
			$mtime = microtime();
			$now = explode(" ",$mtime);
			$now = $now[1];
			
			if($now - $updated->getTimestamp() > $this->ttl) {
				return null;
			} else {
				$this->skipUpdate = true;
				return $cacheDoc->getContent();
			}
		}
		return null;
	}
	
	public function save($response)
	{
		if($this->skipUpdate) {
			return;
		}
	
		$key = $this->getKey();
		$cacheContent = $response->getContent();
		$this->storage->setItem($key, $cacheContent);
	}
	
	public function getKey()
	{
		if(!$this->key) {
			$contextType = $this->context->getType();
			
			$params = $this->context->getParams();
			unset($params['__NAMESPACE__']);
			unset($params['controller']);
			unset($params['action']);
			if(count($params) == 0) {
				$this->key = $contextType;
			} else {
				$this->key = $contextType.'-'.implode('-', $params);
			}
			
		}
		return $this->key;
	}
	
	public function shouldCache()
	{
		if(is_null($this->context)) {
			return false;
		}
		$sessionAdmin = new SessionAdmin();
		if($sessionAdmin->isLogin()) {
			return false;
		}
		
		return $this->context->shouldCache();
	}
}