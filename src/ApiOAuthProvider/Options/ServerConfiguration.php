<?php
namespace ApiOAuthProvider\Options;

use OAuth2\ClientAssertionType\ClientAssertionTypeInterface;
use OAuth2\ScopeInterface;
use OAuth2\TokenType\TokenTypeInterface;

use Zend\Stdlib\AbstractOptions;

class ServerConfigurations extends AbstractOptions
{
    /**
     * @var array;
     */
    protected $storage = array();

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
     * @return the $storage
     */
    public function getStorage()
    {
        return $this->storage;
    }

	/**
     * @param multitype: $storage
     */
    public function setStorage(array $storage)
    {
        $this->storage = $storage;
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
