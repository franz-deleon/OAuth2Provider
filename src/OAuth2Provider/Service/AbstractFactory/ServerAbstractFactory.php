<?php
namespace OAuth2Provider\Service\AbstractFactory;

use OAuth2Provider\Exception;
use OAuth2Provider\Options\ServerConfigurations;

use Zend\ServiceManager;

class ServerAbstractFactory implements ServiceManager\AbstractFactoryInterface
{
    /**
     * @var string
     */
    const REGEX_SERVER_PATTERN = '~^oauth2provider.server.([a-zA-Z0-9_]+)$~';

    protected $serverConfig;
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
        if (preg_match(static::REGEX_SERVER_PATTERN, $requestedName, $serverKeyMatch)
            && !empty($serverKeyMatch[1])
        ) {
            $serverKey     = $serverKeyMatch[1];
            $serverConfigs = $serviceLocator->get('OAuth2Provider\Options\Configuration')->getServers();

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
        $serverKey     = $this->serverKey;
        $serverConfigs = new ServerConfigurations($this->serverConfig);

        // initialize storages
        $storageFactory = $serviceLocator->get('OAuth2Provider/Service/StorageFactory');
        $storages = $storageFactory($serverConfigs->getStorages(), $serverKey);

        // initialize grant types
        $grantTypeFactory = $serviceLocator->get('OAuth2Provider/Service/GrantTypeFactory');
        $grantTypeFactory($serverConfigs->getGrantTypes(), $serverKey);

        return new \stdClass();
    }
}
