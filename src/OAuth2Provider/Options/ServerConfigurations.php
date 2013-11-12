<?php
namespace OAuth2Provider\Options;

use OAuth2\ClientAssertionType\ClientAssertionTypeInterface;
use OAuth2\ScopeInterface;
use OAuth2\TokenType\TokenTypeInterface;

use Zend\Stdlib\AbstractOptions;

class ServerConfigurations extends AbstractOptions
{
    /**
     * @var array;
     */
    protected $storages = array();

    /**
     * @var array
     */
    protected $config = array();

    /**
     * @var array;
     */
    protected $grantTypes = array();

    /**
     * @var array;
     */
    protected $responseTypes = array();

    /**
     * @var array;
     */
    protected $tokenType;

    /**
     * @var array;
     */
    protected $scopeUtil;

    /**
     * @var ClientAssertionTypeInterface;
     */
    protected $clientAssertionType;

    /**
     * @var string;
     */
    protected $serverClass = 'OAuth2\Server';


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

	/**
     * @return the $storage
     */
    public function getStorages()
    {
        return $this->storages;
    }

	/**
     * @param multitype: $storage
     */
    public function setStorages(array $storages)
    {
        $this->storages = $storages;
        return $this;
    }

	/**
     * @return the $grantTypes
     */
    public function getGrantTypes()
    {
        return $this->grantTypes;
    }

	/**
     * @param multitype: $grantTypes
     */
    public function setGrantTypes(array $grantTypes)
    {
        $this->grantTypes = $grantTypes;
        return $this;
    }

	/**
     * @return the $responseTypes
     */
    public function getResponseTypes()
    {
        return $this->responseTypes;
    }

	/**
     * @param multitype: $responseTypes
     */
    public function setResponseTypes(array $responseTypes)
    {
        $this->responseTypes = $responseTypes;
        return $this;
    }

	/**
     * @return the $tokeType
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

	/**
     * @param field_type $tokeType
     */
    public function setTokenType(TokenTypeInterface $tokeType)
    {
        $this->tokenType = $tokeType;
        return $this;
    }

	/**
     * @return the $scopeUtil
     */
    public function getScopeUtil()
    {
        return $this->scopeUtil;
    }

	/**
     * @param field_type $scopeUtil
     */
    public function setScopeUtil(ScopeInterface $scopeUtil)
    {
        $this->scopeUtil = $scopeUtil;
        return $this;
    }

	/**
     * @return the $clientAssertionType
     */
    public function getClientAssertionType()
    {
        return $this->clientAssertionType;
    }

	/**
     * @param field_type $clientAssertionType
     */
    public function setClientAssertionType(ClientAssertionTypeInterface $clientAssertionType)
    {
        $this->clientAssertionType = $clientAssertionType;
    }

	/**
     * @return the $server
     */
    public function getServerClass()
    {
        return $this->serverClass;
    }

	/**
     * @param string $server
     */
    public function setServerClass($server)
    {
        $this->serverClass = $server;
    }
}
