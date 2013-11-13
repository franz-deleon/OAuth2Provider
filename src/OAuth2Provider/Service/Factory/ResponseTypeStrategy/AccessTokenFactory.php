<?php
namespace OAuth2Provider\Service\Factory\ResponseTypeStrategy;

use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;
use OAuth2Provider\Options\ResponseType\AccessTokenConfigurations;

use Zend\ServiceManager;

class AccessTokenFactory implements ServiceManager\FactoryInterface
{
    /**
     * Identifiers
     * This will be used for defaults
     * @var unknown
     */
    const ACCESS_TOKEN_IDENTIFIER = 'access_token';
    const REFRESH_TOKEN_IDENTIFIER = 'refresh_token';

    /**
     * Initialize an OAuth Access Token Response type
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($accessTokenClassName, $params, $serverKey) use ($serviceLocator) {

            $storageContainer = $serviceLocator->get('OAuth2Provider/Containers/StorageContainer');
            $config = new AccessTokenConfigurations($params);

            $tokenStorageName        = $config->getTokenStorage() ?: $config->getStorage();
            $refreshTokenStorageName = $config->getRefreshStorage();

            // check if there is a direct defined 'token storage'
            $tokenStorage = Utilities::storageLookup(
                $serverKey,
                $tokenStorageName,
                $storageContainer,
                $serviceLocator,
                AccessTokenFactory::ACCESS_TOKEN_IDENTIFIER
            );

            // check if there is a direct defined 'refresh token'
            $refreshTokenStorage = Utilities::storageLookup(
                $serverKey,
                $refreshTokenStorageName,
                $storageContainer,
                $serviceLocator,
                AccessTokenFactory::REFRESH_TOKEN_IDENTIFIER
            );

            if (!isset($tokenStorage)) {
                throw new Exception\InvalidServerException(sprintf(
                    "Class '%s' error: storage of type '%s' is required for Access Token '%s'",
                    __METHOD__,
                    AccessTokenFactory::ACCESS_TOKEN_IDENTIFIER,
                    $accessTokenClassName
                ));
            }

            return new $accessTokenClassName($tokenStorage, $refreshTokenStorage, $config->getConfig());
        };
    }
}
