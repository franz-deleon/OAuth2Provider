<?php
namespace OAuth2Provider\Options\GrantType;

use OAuth2Provider\Options\TypeAbstract;

class RefreshTokenConfigurations extends TypeAbstract
{
    /**
     * The refresh token storage to use
     * @var string
     */
    protected $refreshTokenStorage;

    /**
     * Additional configurations
     * <code>
     * array(
     *    'always_issue_new_refresh_token' => false
     * )
     * </code>
     * @var string
     */
    protected $configs = array();

    /**
     * @return the $refreshTokenStorage
     */
    public function getRefreshTokenStorage()
    {
        return $this->refreshTokenStorage;
    }

    /**
     * @param field_type $refreshTokenStorage
     */
    public function setRefreshTokenStorage($refreshTokenStorage)
    {
        $this->refreshTokenStorage = $refreshTokenStorage;
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
