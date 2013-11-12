<?php
namespace OAuth2Provider\Options\ResponseType;

use Zend\Stdlib\AbstractOptions;

class AccessTokenConfigurations extends AbstractOptions
{
    /**
     * The Token Storage object to use
     * Required
     *
     * @var mixed
     */
    protected $tokenStorage;

    /**
     * Refresh Token storage to use
     * Optional
     *
     * @var mixed
     */
    protected $refreshStorage;

    /**
     * Extra configurations
     * Optional
     *
     * @var unknown
     */
    protected $config = array();

	/**
     * @return the $tokenStorage
     */
    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }

	/**
     * @param field_type $tokenStorage
     */
    public function setTokenStorage($tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        return $this;
    }

	/**
     * @return the $refreshStorage
     */
    public function getRefreshStorage()
    {
        return $this->refreshStorage;
    }

	/**
     * @param field_type $refreshStorage
     */
    public function setRefreshStorage($refreshStorage)
    {
        $this->refreshStorage = $refreshStorage;
        return $this;
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
    public function setConfig(array $config)
    {
        $this->config = $config;
        return $this;
    }

}
