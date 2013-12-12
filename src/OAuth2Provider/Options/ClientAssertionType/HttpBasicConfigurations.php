<?php
namespace OAuth2Provider\Options\ClientAssertionType;

use OAuth2Provider\Options\TypeAbstract;

class HttpBasicConfigurations extends TypeAbstract
{
    /**
     * The client credentials storage
     * @var \OAuth2\Storage\ClientCredentialsInterface
     */
    protected $clientCredentialsStorage;

    /**
     * Extra configurations to pass
     * Optional
     *
     * Available config:
     * <code>
     * array(
     *     'allow_credentials_in_request_body' => true
     * )
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
    public function setConfigs($configs)
    {
        $this->configs = $configs;
        return $this;
    }
}
