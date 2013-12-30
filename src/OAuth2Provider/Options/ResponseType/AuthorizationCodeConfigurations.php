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
     * <code>
     * array(
     *    'enforce_redirect'   => false,
     *    'auth_code_lifetime' => 30,
     * )
     * </code>
     * @var array
     */
    protected $configs = array();

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
        return $this;
    }

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
    public function setConfigs($configs)
    {
        $this->configs = $configs;
        return $this;
    }

}
