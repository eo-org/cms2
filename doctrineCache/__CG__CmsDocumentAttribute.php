<?php

namespace DoctrineMongoProxy\__CG__\Cms\Document;

use Doctrine\ODM\MongoDB\Persisters\DocumentPersister;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class Attribute extends \Cms\Document\Attribute implements \Doctrine\ODM\MongoDB\Proxy\Proxy
{
    private $__documentPersister__;
    public $__identifier__;
    public $__isInitialized__ = false;
    public function __construct(DocumentPersister $documentPersister, $identifier)
    {
        $this->__documentPersister__ = $documentPersister;
        $this->__identifier__ = $identifier;
    }
    /** @private */
    public function __load()
    {
        if (!$this->__isInitialized__ && $this->__documentPersister__) {
            $this->__isInitialized__ = true;

            if (method_exists($this, "__wakeup")) {
                // call this after __isInitialized__to avoid infinite recursion
                // but before loading to emulate what ClassMetadata::newInstance()
                // provides.
                $this->__wakeup();
            }

            if ($this->__documentPersister__->load($this->__identifier__, $this) === null) {
                throw \Doctrine\ODM\MongoDB\DocumentNotFoundException::documentNotFound(get_class($this), $this->__identifier__);
            }
            unset($this->__documentPersister__, $this->__identifier__);
        }
    }

    /** @private */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    
    public function getFormElement()
    {
        $this->__load();
        return parent::getFormElement();
    }

    public function getOptions()
    {
        $this->__load();
        return parent::getOptions();
    }

    public function getOptionLabel($optKey)
    {
        $this->__load();
        return parent::getOptionLabel($optKey);
    }

    public function exchangeArray($data)
    {
        $this->__load();
        return parent::exchangeArray($data);
    }

    public function getArrayCopy()
    {
        $this->__load();
        return parent::getArrayCopy();
    }

    public function isNew()
    {
        $this->__load();
        return parent::isNew();
    }

    public function setFromArray($dataArray)
    {
        $this->__load();
        return parent::setFromArray($dataArray);
    }

    public function toArray()
    {
        $this->__load();
        return parent::toArray();
    }

    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter)
    {
        $this->__load();
        return parent::setInputFilter($inputFilter);
    }

    public function getInputFilter()
    {
        $this->__load();
        return parent::getInputFilter();
    }

    public function injectObjectManager(\Doctrine\Common\Persistence\ObjectManager $objectManager, \Doctrine\Common\Persistence\Mapping\ClassMetadata $classMetadata)
    {
        $this->__load();
        return parent::injectObjectManager($objectManager, $classMetadata);
    }

    public function __call($method, $args)
    {
        $this->__load();
        return parent::__call($method, $args);
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'attributesetId', 'type', 'UUID', 'code', 'label', 'description', 'options', 'required', 'sort');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->__documentPersister__) {
            $this->__isInitialized__ = true;
            $class = $this->__documentPersister__->getClassMetadata();
            $original = $this->__documentPersister__->load($this->__identifier__);
            if ($original === null) {
                throw \Doctrine\ODM\MongoDB\MongoDBException::documentNotFound(get_class($this), $this->__identifier__);
            }
            foreach ($class->reflFields AS $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->__documentPersister__, $this->__identifier__);
        }
        
    }
}