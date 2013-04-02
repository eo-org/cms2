<?php
namespace Cms\Cache\Storage\Adapter;

use Zend\Form\Element\Time;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Date;

use stdClass;
use Traversable;
use Zend\Cache\Exception;
use Zend\Stdlib\ErrorHandler;
use Zend\Cache\Storage\Adapter\AbstractAdapter, Zend\Cache\Storage\ClearExpiredInterface;

class Mongo extends AbstractAdapter
// implements ClearExpiredInterface
{
	protected $dm;
	
    protected $pageCacheDoc;
    
    public function __construct($options = null)
    {
        parent::__construct($options);
    }

    public function setDocumentManager($dm)
    {
    	$this->dm = $dm;
    }

    /* options */

    /**
     * Set options.
     *
     * @param  array|Traversable|DbaOptions $options
     * @return Apc
     * @see    getOptions()
     */
    public function setOptions($options)
    {
        if (!$options instanceof MongoOptions) {
            $options = new MongoOptions($options);
        }

        return parent::setOptions($options);
    }

    /**
     * Get options.
     *
     * @return DbaOptions
     * @see    setOptions()
     */
    public function getOptions()
    {
        if (!$this->options) {
            $this->setOptions(new MongoOptions());
        }
        return $this->options;
    }

    /* TotalSpaceCapableInterface */

    /**
     * Get total space in bytes
     *
     * @return int|float
     */
    public function getTotalSpace()
    {
        if ($this->totalSpace === null) {
            $pathname = $this->getOptions()->getPathname();

            if ($pathname === '') {
                throw new Exception\LogicException('No pathname to database file');
            }

            ErrorHandler::start();
            $total = disk_total_space(dirname($pathname));
            $error = ErrorHandler::stop();
            if ($total === false) {
                throw new Exception\RuntimeException("Can't detect total space of '{$pathname}'", 0, $error);
            }
            $this->totalSpace = $total;

            // clean total space buffer on change pathname
            $events     = $this->getEventManager();
            $handle     = null;
            $totalSpace = & $this->totalSpace;
            $callback   = function ($event) use (& $events, & $handle, & $totalSpace) {
                $params = $event->getParams();
                if (isset($params['pathname'])) {
                    $totalSpace = null;
                    $events->detach($handle);
                }
            };
            $handle = $events->attach('option', $callback);
        }

        return $this->totalSpace;
    }

    /* AvailableSpaceCapableInterface */

    /**
     * Get available space in bytes
     *
     * @return int|float
     */
    public function getAvailableSpace()
    {
        $pathname = $this->getOptions()->getPathname();

        if ($pathname === '') {
            throw new Exception\LogicException('No pathname to database file');
        }

        ErrorHandler::start();
        $avail = disk_free_space(dirname($pathname));
        $error = ErrorHandler::stop();
        if ($avail === false) {
            throw new Exception\RuntimeException("Can't detect free space of '{$pathname}'", 0, $error);
        }

        return $avail;
    }

    /* FlushableInterface */

    /**
     * Flush the whole storage
     *
     * @return boolean
     */
    public function flush()
    {
        $pathname = $this->getOptions()->getPathname();

        if ($pathname === '') {
            throw new Exception\LogicException('No pathname to database file');
        }

        if (file_exists($pathname)) {

            // close the dba file before delete
            // and reopen (create) on next use
            $this->_close();

            ErrorHandler::start();
            $result = unlink($pathname);
            $error  = ErrorHandler::stop();
            if (!$result) {
                throw new Exception\RuntimeException("unlink('{$pathname}') failed", 0, $error);
            }
        }

        return true;
    }

    /* ClearByNamespaceInterface */

    /**
     * Remove items by given namespace
     *
     * @param string $namespace
     * @return boolean
     */
    public function clearByNamespace($namespace)
    {
        $prefix  = $namespace . $this->getOptions()->getNamespaceSeparator();
        $prefixl = strlen($prefix);
        $result  = true;

        $this->_open();

        do { // Workaround for PHP-Bug #62491 & #62492
            $recheck     = false;
            $internalKey = dba_firstkey($this->handle);
            while ($internalKey !== false && $internalKey !== null) {
                if (substr($internalKey, 0, $prefixl) === $prefix) {
                    $result = dba_delete($internalKey, $this->handle) && $result;
                }

                $internalKey = dba_nextkey($this->handle);
            }
        } while ($recheck);

        return $result;
    }

    /* ClearByPrefixInterface */

    /**
     * Remove items matching given prefix
     *
     * @param string $prefix
     * @return boolean
     */
    public function clearByPrefix($prefix)
    {
        $options = $this->getOptions();
        $prefix  = $options->getNamespace() . $options->getNamespaceSeparator() . $prefix;
        $prefixl = strlen($prefix);
        $result  = true;

        $this->_open();

        do { // Workaround for PHP-Bug #62491 & #62492
            $recheck     = false;
            $internalKey = dba_firstkey($this->handle);
            while ($internalKey !== false && $internalKey !== null) {
                if (substr($internalKey, 0, $prefixl) === $prefix) {
                    $result = dba_delete($internalKey, $this->handle) && $result;
                    $recheck = true;
                }

                $internalKey = dba_nextkey($this->handle);
            }
        } while ($recheck);

        return $result;
    }

    /* IterableInterface */

    /**
     * Get the storage iterator
     *
     * @return ApcIterator
     */
    public function getIterator()
    {
        $options = $this->getOptions();
        $prefix  = $options->getNamespace() . $options->getNamespaceSeparator();

        return new DbaIterator($this, $this->handle, $prefix);
    }

    /* OptimizableInterface */

    /**
     * Optimize the storage
     *
     * @return boolean
     * @return Exception\RuntimeException
     */
    public function optimize()
    {
        $this->_open();
        if (!dba_optimize($this->handle)) {
            throw new Exception\RuntimeException('dba_optimize failed');
        }
        return true;
    }

    /* reading */

    /**
     * Internal method to get an item.
     *
     * @param  string  $normalizedKey
     * @param  boolean $success
     * @param  mixed   $casToken
     * @return mixed Data on success, null on failure
     * @throws Exception\ExceptionInterface
     */
    protected function internalGetItem(& $normalizedKey, & $success = null, & $casToken = null)
    {
    	if($this->internalHasItem($normalizedKey)) {
    		$success = true;
    		return $this->pageCacheDoc;
    	} else {
    		$success = false;
    		return null;
    	}
    }

    /**
     * Internal method to test if an item exists.
     *
     * @param  string $normalizedKey
     * @return boolean
     * @throws Exception\ExceptionInterface
     */
    protected function internalHasItem(& $normalizedKey)
    {
    	if(is_null($this->pageCacheDoc)) {
    		$repositoryName = $this->getOptions()->getRepositoryName();
    		$this->pageCacheDoc = $this->dm->getRepository($repositoryName)->findOneByKey($normalizedKey);
    		if(is_null($this->pageCacheDoc)) {
    			$this->pageCacheDoc = false;
    			return false;
    		}
    		return true;
    	}
    	if($this->pageCacheDoc !== false) {
    		return true;
    	} else {
	        return false;
    	}
    }

    /* writing */

    /**
     * Internal method to store an item.
     *
     * @param  string $normalizedKey
     * @param  mixed  $value
     * @return boolean
     * @throws Exception\ExceptionInterface
     */
    protected function internalSetItem(& $normalizedKey, & $value)
    {
    	if($this->internalHasItem($normalizedKey)) {
    		$pageCacheDoc = $this->pageCacheDoc;
    	} else {
    		$repositoryName = $this->getOptions()->getRepositoryName();
    		$pageCacheDoc = new $repositoryName;
    		$pageCacheDoc->setKey($normalizedKey);
    		$pageCacheDoc->setType('pageCache');
    	}
    	$pageCacheDoc->setUpdated(new \MongoDate());
    	$pageCacheDoc->setContent($value);
    	$this->dm->persist($pageCacheDoc);
    	$this->dm->flush();
    	$this->pageCacheDoc = $pageCacheDoc;
        return true;
    }

    /**
     * Add an item.
     *
     * @param  string $normalizedKey
     * @param  mixed  $value
     * @return boolean
     * @throws Exception\ExceptionInterface
     */
    protected function internalAddItem(& $normalizedKey, & $value)
    {
        $options     = $this->getOptions();
        $prefix      = $options->getNamespace() . $options->getNamespaceSeparator();
        $internalKey = $prefix . $normalizedKey;

        $this->_open();

        // Workaround for PHP-Bug #54242 & #62489
        if (dba_exists($internalKey, $this->handle)) {
            return false;
        }

        // Workaround for PHP-Bug #54242 & #62489
        // dba_insert returns true if key already exists
        ErrorHandler::start();
        $result = dba_insert($internalKey, $value, $this->handle);
        $error  = ErrorHandler::stop();
        if (!$result || $error) {
            return false;
        }

        return true;
    }

    /**
     * Internal method to remove an item.
     *
     * @param  string $normalizedKey
     * @return boolean
     * @throws Exception\ExceptionInterface
     */
    protected function internalRemoveItem(& $normalizedKey)
    {
        $options     = $this->getOptions();
        $prefix      = $options->getNamespace() . $options->getNamespaceSeparator();
        $internalKey = $prefix . $normalizedKey;

        $this->_open();

        // Workaround for PHP-Bug #62490
        if (!dba_exists($internalKey, $this->handle)) {
            return false;
        }

        return dba_delete($internalKey, $this->handle);
    }

    /* status */

    /**
     * Internal method to get capabilities of this adapter
     *
     * @return Capabilities
     */
    protected function internalGetCapabilities()
    {
        if ($this->capabilities === null) {
            $marker       = new stdClass();
            $capabilities = new Capabilities(
                $this,
                $marker,
                array(
                    'supportedDatatypes' => array(
                        'NULL'     => 'string',
                        'boolean'  => 'string',
                        'integer'  => 'string',
                        'double'   => 'string',
                        'string'   => true,
                        'array'    => false,
                        'object'   => false,
                        'resource' => false,
                    ),
                    'minTtl'             => 0,
                    'supportedMetadata'  => array(),
                    'maxKeyLength'       => 0, // TODO: maxKeyLength ????
                    'namespaceIsPrefix'  => true,
                    'namespaceSeparator' => $this->getOptions()->getNamespaceSeparator(),
                )
            );

            // update namespace separator on change option
            $this->getEventManager()->attach('option', function ($event) use ($capabilities, $marker) {
                $params = $event->getParams();

                if (isset($params['namespace_separator'])) {
                    $capabilities->setNamespaceSeparator($marker, $params['namespace_separator']);
                }
            });

            $this->capabilities     = $capabilities;
            $this->capabilityMarker = $marker;
        }

        return $this->capabilities;
    }

    /**
     * Open the database if not already done.
     *
     * @return void
     * @throws Exception\LogicException
     * @throws Exception\RuntimeException
     */
    protected function _open()
    {
    	echo 'OPENED';
    	die();
    }

    /**
     * Close database file if opened
     *
     * @return void
     */
    protected function _close()
    {
    	echo 'Closed';
    	die();
    }
}
