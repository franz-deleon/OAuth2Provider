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
    const REFRESH_TOKEN_IDENTIFIER = 'refresh_token';

    /**
     * Initialize an OAuth Access Token Response type
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($redfreshTokenClassName, $options, $serverKey) use ($serviceLocator) {

            $options = $serviceLocator->get('OAuth2Provider/Options/GrantType/RefreshToken')->setFromArray($options);

            // check if there is a direct defined 'token storage'
            $tokenStorage = Utilities::storageLookup(
                $serverKey,
                $options->getRefreshTokenStorage() ?: $options->getStorage(),
                $serviceLocator->get('OAuth2Provider/Containers/StorageContainer'),
                $serviceLocator,
                RefreshTokenFactory::REFRESH_TOKEN_IDENTIFIER
            );

            if (empty($tokenStorage)) {
                throw new Exception\InvalidServerException(sprintf(
                    "Class '%s' error: storage of type '%s' is required for '%s'",
                    __METHOD__,
                    RefreshTokenFactory::REFRESH_TOKEN_IDENTIFIER,
                    $redfreshTokenClassName
                ));
            }

            return new $redfreshTokenClassName($tokenStorage, $options->getConfigs());
        };
    }
}
