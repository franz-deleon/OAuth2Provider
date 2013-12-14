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

        $server = $options->getServerClass();
        $server = new $server();

        if (!$server instanceof ServerInterface) {
            throw new Exception\InvalidClassException(sprintf(
                "Error: %s: Server '%s' should implement OAuth2Provider\ServerInterface",
                __METHOD__,
                get_class($server)
            ));
        }

        $storage      = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/StorageFactory');
        $config       = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/ConfigFactory');
        $grantType    = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/GrantTypeFactory');
        $responseType = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/ResponseTypeFactory');
        $tokenType    = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/TokenTypeFactory');
        $scopeType    = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/ScopeTypeFactory');
        $clientAssertionType = $serviceLocator->get('OAuth2Provider/Service/ServerFeature/ClientAssertionTypeFactory');

        $server->setOAuth2Server(new OAuth2Server(
            $storage($options->getStorages(), $this->serverKey),
            $config($options->getConfigs(), $this->serverKey),
            $grantType($options->getGrantTypes(), $this->serverKey),
            $responseType($options->getResponseTypes(), $this->serverKey),
            $tokenType($options->getTokenType(), $this->serverKey),
            $scopeType($options->getScopeUtil(), $this->serverKey),
            $clientAssertionType($options->getClientAssertionType(), $this->serverKey)
        ));

        return $server;
    }
}
