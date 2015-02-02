<?php

namespace Acme\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Acme\DemoBundle\Annotation\ApiSyncEntity;
use Acme\DemoBundle\Annotation\ApiSyncContent;

/**
 * Class Contact
 * @package Acme\DemoBundle\Entity
 *
 * @ORM\Table(name="acme_contact")
 * @ORM\Entity()
 * @ApiSyncEntity(entity="Contact")
 */
class Contact
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var name
     * @ORM\Column(type="string", length=50, nullable=true)
     * @ApiSyncContent(name="api_name")
     */
    private $name;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}