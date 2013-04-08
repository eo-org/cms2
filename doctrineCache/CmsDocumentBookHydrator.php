<?php

namespace DoctrineMongoHydrator;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class CmsDocumentBookHydrator implements HydratorInterface
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
        if (isset($data['label'])) {
            $value = $data['label'];
            $return = (string) $value;
            $this->class->reflFields['label']->setValue($document, $return);
            $hydratedData['label'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['alias'])) {
            $value = $data['alias'];
            $return = (string) $value;
            $this->class->reflFields['alias']->setValue($document, $return);
            $hydratedData['alias'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['layoutAlias'])) {
            $value = $data['layoutAlias'];
            $return = (string) $value;
            $this->class->reflFields['layoutAlias']->setValue($document, $return);
            $hydratedData['layoutAlias'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['description'])) {
            $value = $data['description'];
            $return = (string) $value;
            $this->class->reflFields['description']->setValue($document, $return);
            $hydratedData['description'] = $return;
        }

        /** @Field(type="hash") */
        if (isset($data['bookIndex'])) {
            $value = $data['bookIndex'];
            $return = $value;
            $this->class->reflFields['bookIndex']->setValue($document, $return);
            $hydratedData['bookIndex'] = $return;
        }
        return $hydratedData;
    }
}