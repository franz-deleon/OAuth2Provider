<?php
namespace OAuth2Provider\Options\ResponseType;

use OAuth2Provider\Options\TypeAbstract;

class AuthorizationCodeConfigurations extends TypeAbstract
{
    /**
     * Authorization code storage
     * @var mixed|OAuth2\Storage\AuthorizationCodeInterface
     */
    protected $authorizationCodeStorage;

    /**
     * Extra Configurations to pass
     * Optional
     * @var array
     */
    protected $config = array();

	/**
     * @return the $authorizationCodeStorage
     */
    public function getAuthorizationCodeStorage()
    {
        return $this->authorizationCodeStorage;
    }

	/**
     * @param field_type $authorizationCodeStorage
     */
    public function setAuthorizationCodeStorage($authorizationCodeStorage)
    {
        $this->authorizationCodeStorage = $authorizationCodeStorage;
    }

	/**
     * @return the $config
     */
    public function getConfig()
    {
        return $this->config;
    }

	/**
     * @param multitype: $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

}
