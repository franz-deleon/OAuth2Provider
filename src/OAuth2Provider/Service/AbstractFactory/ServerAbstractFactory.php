<?php
namespace OAuth2Provider\Service\AbstractFactory;

use OAuth2Provider\Exception;

use Zend\ServiceManager;

class ServerAbstractFactory implements ServiceManager\AbstractFactoryInterface
{
    /**
     * @var string
     */
    const REGEX_SERVER_PATTERN = '~^oauth2provider.server.([a-zA-Z0-9_]+)$~';

    /**
     * @var array
     */
    protected $serverConfig;

    /**
     * @var string
     */
    protected $serverKey;

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceManager\ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        // for performance, do a prelim check before checking against regex
        if (0 !== strpos($requestedName, 'oauth2provider.server.')) {
            return false;
        }

        if (preg_match(static::REGEX_SERVER_PATTERN, $requestedName, $serverKeyMatch)
            && !empty($serverKeyMatch[1])
        ) {
            $serverKey = $serverKeyMatch[1];

            $serverConfigs = $serviceLocator->get('OAuth2Provider/Options/Configuration')->getServers();
            if (isset($serverConfigs[$serverKey])) {
                $this->serverKey    = $serverKey;
                $this->serverConfig = $serverConfigs[$serverKey];

                return true;
            }

            throw new Exception\InvalidServerException(sprintf(
                "Class '%s' error: server configuration '%s' does not exist",
                __METHOD__,
                $serverKey
            ));
        }

        return false;
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     */
    public function createServiceWithName(ServiceManager\ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $options = $serviceLocator->get('OAuth2Provider/Options/Server')->setFromArray($this->serverConfig);

        // initialize storages
        $storageFactory = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/StorageFactory');
        $storages = $storageFactory($options->getStorages(), $this->serverKey);

        // store config
        $configFactory = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/ConfigFactory');
        $configs = $configFactory($options->getConfigs(), $this->serverKey);

        // initialize grant types
        $grantTypeFactory = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/GrantTypeFactory');
        $grantTypes = $grantTypeFactory($options->getGrantTypes(), $this->serverKey);

        // initialize response types
        $responseTypeFactory = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/ResponseTypeFactory');
        $responseTypes = $responseTypeFactory($options->getResponseTypes(), $this->serverKey);

        // initialize token type
        $tokenTypeFactory = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/TokenTypeFactory');
        $tokenTypes = $tokenTypeFactory($options->getTokenType(), $this->serverKey);

        // initialize scope
        $scopeTypeFactory = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/ScopeTypeFactory');
        $scope = $scopeTypeFactory($options->getScopeUtil(), $this->serverKey);

        // initialize the actual server
        $server = $options->getServerClass();
        $server = new $server($storages, $configs, $grantTypes, $responseTypes, $tokenTypes, $scope);

        return $server;
    }
}
