<?php

namespace Acme\DemoBundle\Annotation;

/**
 * Class ApiSyncEntity
 * @package Acme\DemoBundle\Annotations
 *
 * @Annotation
 * @Target("CLASS")
 */
final class ApiSyncEntity
{
    /**
     * @var entity
     */
    private $entity;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->entity = $data['entity'];
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }
}