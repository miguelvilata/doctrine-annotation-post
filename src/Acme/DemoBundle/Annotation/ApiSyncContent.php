<?php

namespace Acme\DemoBundle\Annotation;

/**
 * @Annotation
 */
class ApiSyncContent
{
    /**
     * @var name
     */
    private $name;

    /**
     * @var required
     */
    private $required;

    /**
     * @var default
     */
    private $default;

    /**
     * @param $options
     */
    public function __construct($options)
    {
        foreach ($options as $key => $value) {
            if (! property_exists($this, $key)) {
                throw new \InvalidArgumentException(sprintf('Property "%s" does not exist', $key));
            }

            $this->$key = $value;
        }
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getRequired()
    {
        return (bool)$this->required;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }
}