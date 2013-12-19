<?php
namespace OAuth2Provider\Options\GrantType;

use OAuth2Provider\Options\TypeAbstract;

class ClientCredentialsConfigurations extends TypeAbstract
{
    /**
     * Client credentials storage
     * @var string
     */
    protected $clientCredentialsStorage;

    /**
     * Additional configurations
     * Available configuration key
     * <code>
     * array(
     *     'allow_credentials_in_request_body' => true,
     * );
     * </code>
     * @var array
     */
    protected $configs = array();

	/**
     * @return the $clientCredentialsStorage
     */
    public function getClientCredentialsStorage()
    {
        return $this->clientCredentialsStorage;
    }

	/**
     * @param field_type $clientCredentialsStorage
     */
    public function setClientCredentialsStorage($clientCredentialsStorage)
    {
        $this->clientCredentialsStorage = $clientCredentialsStorage;
        return $this;
    }

	/**
     * @return the $configs
     */
    public function getConfigs()
    {
        return $this->configs;
    }

	/**
     * @param multitype: $configs
     */
    public function setConfigs(array $configs)
    {
        $this->configs = $configs;
        return $this;
    }
}
