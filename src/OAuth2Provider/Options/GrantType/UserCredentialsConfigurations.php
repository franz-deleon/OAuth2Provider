<?php
namespace OAuth2Provider\Options\GrantType;

use OAuth2Provider\Options\TypeAbstract;

class UserCredentialsConfigurations extends TypeAbstract
{
    /**
     * Storage object to pass to User Credentials Grant Type
     * Required
     *
     * @var string
     */
    protected $userCredentialsStorage;

	/**
     * @return the $storage
     */
    public function getUserCredentialsStorage()
    {
        return $this->userCredentialsStorage;
    }

	/**
     * @param field_type $storage
     */
    public function setUserCredentialsStorage($storage)
    {
        $this->userCredentialsStorage = $storage;
        return $this;
    }
}
