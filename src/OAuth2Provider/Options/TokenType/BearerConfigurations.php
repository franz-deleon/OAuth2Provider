<?php
namespace OAuth2Provider\Options\TokenType;

use OAuth2Provider\Options\TypeAbstract;

class BearerConfigurations extends TypeAbstract
{
    /**
     * Additional configuration to pass to bearer object
     * Available configs:
     *
     * <code>
     * array(
     *     'token_param_name'         => 'access_token',
     *     'token_bearer_header_name' => 'Bearer',
     * )
     * </code>
     *
     * @var array
     */
    protected $configs = array();

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
    public function setConfigs(array $config)
    {
        $this->configs = $config;
        return $this;
    }
}
