<?php
namespace OAuth2Provider\Options\GrantType;

use Zend\Stdlib\AbstractOptions;

class UserCredentialsConfigurations extends AbstractOptions
{
    /**
     * Storage object to pass to User Credentials Grant Type
     * Required
     *
     * @var string
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
