<?php
namespace OAuth2Provider\Options;

use Zend\Stdlib\AbstractOptions;

class ServerConfigurations extends AbstractOptions
{
    /**
     * Storages available for mapping for this server
     *
     * List of storage keys:
     *
     * 1. 'access_token',
     * 2. 'authorization_code',
     * 3. 'client_credentials',
     * 4. 'client',
     * 5. 'refresh_token',
     * 6. 'user_credentials',
     * 7. 'jwt_bearer',
     * 8. 'scope',
     *
     * @var array;
     */
    protected $storages = array();

    /**
     * Configurations to pass to the server
     *
     * List of default key/value configurations:
     *
     *   'access_lifetime'            => 3600,
     *   'www_realm'                  => 'Service',
     *   'token_param_name'           => 'access_token',
     *   'token_bearer_header_name'   => 'Bearer',
     *   'enforce_state'              => true,
     *   'require_exact_redirect_uri' => true,
     *   'allow_implicit'             => false,
     *   'allow_credentials_in_request_body' => true,
     *
     * Optional
     *
     * @var array
     */
    protected $configs = array();

    /**
     * Grant types to pass to the server
     * Strategies available:
     *
     * 1. user_credentials
     *
     * Optional
     * @var array;
     */
    protected $grantTypes = array();

    /**
     * Response type to pass to the server
     * Strategies available:
     *
     * 1. access_token
     * 2. authorization_code
     *
     * Optional
     *
     * @var array;
     */
    protected $responseTypes = array();

    /**
     * Token type to pass to the server
     * Optional
     *
     * @var mixed|TokenTypeInterface
     */
    protected $tokenType;

    /**
     * Scope Utilitity to pass to the server
     * Optional
     *
     * @var mixed|ScopeInterface;
     */
    protected $scopeUtil;

    /**
     * Assertion type to pass to the server
     * Optional
     *
     * @var mixed|ClientAssertionTypeInterface;
     */
    protected $clientAssertionType;

    /**
     * The default OAuth2 server class
     * Needs to be FQNS
     *
     * Required
     *
     * @var string;
     */
    protected $serverClass = 'OAuth2Provider\Server';

    /**
     * The version of the server
     * @var string
     */
    protected $version;

    /**
     * The controller the server should use
     * @var string
     */
    protected $controller;

    /**
     * @return the $config
     */
    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * @param multitype: $config
     */
    public function setConfigs(array $configs)
    {
        $this->configs = $configs;
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
     * @param field_type $tokenType
     */
    public function setTokenType($tokenType)
    {
        $this->tokenType = $tokenType;
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
    public function setScopeUtil($scopeUtil)
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
    public function setClientAssertionType($clientAssertionType)
    {
        $this->clientAssertionType = $clientAssertionType;
        return $this;
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
        return $this;
    }

    /**
     * @return the $version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return the $controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }
}
