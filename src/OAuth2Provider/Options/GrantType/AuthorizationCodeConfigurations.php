<?php
namespace OAuth2Provider\Options\GrantType;

use OAuth2Provider\Options\TypeAbstract;

class AuthorizationCodeConfigurations extends TypeAbstract
{
    protected $authorizationCodeStorage;

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
}
