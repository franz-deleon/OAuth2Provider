<?php
namespace OAuth2Provider\Service\AbstractFactory;

use OAuth2Provider\Exception;
use OAuth2Provider\ServerInterface;

use OAuth2\Server as OAuth2Server;

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

            $configs       = $serviceLocator->get('OAuth2Provider/Options/Configuration');
            $serverConfigs = $configs->getServers();
            if (isset($serverConfigs[$serverKey])) {
                $this->serverKey = $serverKey;

                // checks for a version. If no version exists use the first server found
                $mvcEvent = $serviceLocator->get('Application')->getMvcEvent();
                if (isset($mvcEvent) && null !== $mvcEvent->getRouteMatch()) {
                    $version = $mvcEvent->getRouteMatch()->getParam('version');
                }
                if (empty($version)) {
                    $version = $configs->getMainVersion();
                }

                if (null !== $version) {
                    if (!empty($serverConfigs[$serverKey]['version']) && $version === $serverConfigs[$serverKey]['version']) {
                        $this->serverConfig = $serverConfigs[$serverKey];
                        return true;
                    } else {
                        foreach ($serverConfigs[$serverKey] as $storage) {
                            if (!empty($storage['version']) && $storage['version'] === $version) {
                                $this->serverConfig = $storage;
                                return true;
                            }
                        }
                    }
                }

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

        $server = $options->getServerClass();
        $server = new $server();

        $storage      = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/StorageFactory');
        $config       = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/ConfigFactory');
        $grantType    = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/GrantTypeFactory');
        $responseType = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/ResponseTypeFactory');
        $tokenType    = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/TokenTypeFactory');
        $scopeType    = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/ScopeTypeFactory');
        $clientAssertionType = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/ClientAssertionTypeFactory');

        $ouath2server = new OAuth2Server(
            $storage($options->getStorages(), $this->serverKey),
            $config($options->getConfigs(), $this->serverKey),
            $grantType($options->getGrantTypes(), $this->serverKey),
            $responseType($options->getResponseTypes(), $this->serverKey),
            $tokenType($options->getTokenType(), $this->serverKey),
            $scopeType($options->getScopeUtil(), $this->serverKey),
            $clientAssertionType($options->getClientAssertionType(), $this->serverKey)
        );

        if ($server instanceof ServerInterface) {
            $server->setOAuth2Server($ouath2server);
            return $server;
        }

        return $ouath2server;
    }
}
