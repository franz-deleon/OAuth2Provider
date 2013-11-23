<?php
namespace OAuth2Provider\Options\ScopeType;

use OAuth2Provider\Options\TypeAbstract;

class ScopeConfigurations extends TypeAbstract
{
    /**
     * Should we use the already defined scope storage?
     * This flag will bypass all the specific configurations
     * defined below.
     *
     * Defaults to true
     *
     * @var boolean
     */
    protected $useDefinedScopeStorage = true;

    /**
     * Default scope
     * @var string
     */
    protected $defaultScope;

    /**
     * List of supported scopes
     * @var array
     */
    protected $clientSupportedScopes = array();

    /**
     * List of default scopes
     * @var array
     */
    protected $clientDefaultScopes = array();

    /**
     * List of supported scopes
     * @var array
     */
    protected $supportedScopes = array();

    /**
     * @return the $defaultScope
     */
    public function getDefaultScope()
    {
        return $this->defaultScope;
    }

    /**
     * @param field_type $defaultScope
     */
    public function setDefaultScope($defaultScope)
    {
        $this->defaultScope = $defaultScope;
        return $this;
    }

    /**
     * @return the $clientSupportedScopes
     */
    public function getClientSupportedScopes()
    {
        return $this->clientSupportedScopes;
    }

    /**
     * @param multitype: $clientSupportedScopes
     */
    public function setClientSupportedScopes(array $clientSupportedScopes)
    {
        $this->clientSupportedScopes = $clientSupportedScopes;
        return $this;
    }

    /**
     * @return the $clientDefaultScopes
     */
    public function getClientDefaultScopes()
    {
        return $this->clientDefaultScopes;
    }

    /**
     * @param multitype: $clientDefaultScopes
     */
    public function setClientDefaultScopes(array $clientDefaultScopes)
    {
        $this->clientDefaultScopes = $clientDefaultScopes;
        return $this;
    }

    /**
     * @return the $supportedScopes
     */
    public function getSupportedScopes()
    {
        return $this->supportedScopes;
    }

    /**
     * @param multitype: $supportedScopes
     */
    public function setSupportedScopes(array $supportedScopes)
    {
        $this->supportedScopes = $supportedScopes;
        return $this;
    }

    /**
     * @return the $useDefinedStorages
     */
    public function getUseDefinedScopeStorage()
    {
        return $this->useDefinedScopeStorage;
    }

    /**
     * @param boolean $useDefinedScopeStorage
     */
    public function setUseDefinedScopeStorage($useDefinedScopeStorage)
    {
        $this->useDefinedScopeStorage = (bool) $useDefinedScopeStorage;
        return $this;
    }
}
