<?php
namespace OAuth2Provider\Service\Factory\GrantTypeStrategy;

use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager;

class RefreshTokenFactory implements ServiceManager\FactoryInterface
{
    /**
     * Identifiers
     * This will be used for defaults
     * @var ustring
     */
    const IDENTIFIER = 'refresh_token';

    /**
     * Initialize an OAuth Access Token Response type
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($refreshTokenClassName, $options, $serverKey) use ($serviceLocator) {

            $options = $serviceLocator->get('OAuth2Provider/Options/GrantType/RefreshToken')->setFromArray($options);

            // check if there is a direct defined 'token storage'
            $refreshTokenStorage = Utilities::storageLookup(
                $serverKey,
                $options->getRefreshTokenStorage() ?: $options->getStorage(),
                $serviceLocator->get('OAuth2Provider/Containers/StorageContainer'),
                $serviceLocator,
                RefreshTokenFactory::IDENTIFIER
            );

            if (empty($refreshTokenStorage)) {
                throw new Exception\InvalidServerException(sprintf(
                    "Class '%s' error: storage of type '%s' is required for '%s'",
                    __METHOD__,
                    RefreshTokenFactory::IDENTIFIER,
                    $refreshTokenClassName
                ));
            }

            return new $refreshTokenClassName($refreshTokenStorage, $options->getConfigs());
        };
    }
}
