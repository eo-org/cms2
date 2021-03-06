<?php

namespace DoctrineMongoHydrator;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class CmsDocumentBookPageHydrator implements HydratorInterface
{
    private $dm;
    private $unitOfWork;
    private $class;

    public function __construct(DocumentManager $dm, UnitOfWork $uow, ClassMetadata $class)
    {
        $this->dm = $dm;
        $this->unitOfWork = $uow;
        $this->class = $class;
    }

    public function hydrate($document, $data, array $hints = array())
    {
        $hydratedData = array();

        /** @Field(type="id") */
        if (isset($data['_id'])) {
            $value = $data['_id'];
            $return = $value instanceof \MongoId ? (string) $value : $value;
            $this->class->reflFields['id']->setValue($document, $return);
            $hydratedData['id'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['bookId'])) {
            $value = $data['bookId'];
            $return = (string) $value;
            $this->class->reflFields['bookId']->setValue($document, $return);
            $hydratedData['bookId'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['label'])) {
            $value = $data['label'];
            $return = (string) $value;
            $this->class->reflFields['label']->setValue($document, $return);
            $hydratedData['label'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['fulltext'])) {
            $value = $data['fulltext'];
            $return = (string) $value;
            $this->class->reflFields['fulltext']->setValue($document, $return);
            $hydratedData['fulltext'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['alias'])) {
            $value = $data['alias'];
            $return = (string) $value;
            $this->class->reflFields['alias']->setValue($document, $return);
            $hydratedData['alias'] = $return;
        }

        /** @Field(type="date") */
        if (isset($data['created'])) {
            $value = $data['created'];
            if ($value instanceof \MongoDate) { $date = new \DateTime(); $date->setTimestamp($value->sec); $return = $date; } else { $return = new \DateTime($value); }
            $this->class->reflFields['created']->setValue($document, clone $return);
            $hydratedData['created'] = $return;
        }

        /** @Field(type="date") */
        if (isset($data['updated'])) {
            $value = $data['updated'];
            if ($value instanceof \MongoDate) { $date = new \DateTime(); $date->setTimestamp($value->sec); $return = $date; } else { $return = new \DateTime($value); }
            $this->class->reflFields['updated']->setValue($document, clone $return);
            $hydratedData['updated'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['editor'])) {
            $value = $data['editor'];
            $return = (string) $value;
            $this->class->reflFields['editor']->setValue($document, $return);
            $hydratedData['editor'] = $return;
        }
        return $hydratedData;
    }
}