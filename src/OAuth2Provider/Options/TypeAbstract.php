<?php
namespace OAuth2Provider\Options;

use Zend\Stdlib\AbstractOptions;

class TypeAbstract extends AbstractOptions
{
    /**
     * Standard storage
     * @var mixed
     */
    protected $storage;

	/**
     * @return the $storage
     */
    public function getStorage()
    {
        return $this->storage;
    }

	/**
     * @param field_type $storage
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;
        return $this;
    }
}
