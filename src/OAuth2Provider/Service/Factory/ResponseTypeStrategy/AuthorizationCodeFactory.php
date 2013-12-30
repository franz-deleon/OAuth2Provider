<?php
namespace OAuth2Provider\Service\Factory\ResponseTypeStrategy;

use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager;

class AuthorizationCodeFactory implements ServiceManager\FactoryInterface
{
    /**
     * Identifiers
     * This will be used for defaults
     * @var string
     */
    const IDENTIFIER = 'authorization_code';

    /**
     * Initialize an OAuth Authorization Code Response type
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($authorizationCodeClassName, $options, $serverKey) use ($serviceLocator) {
            $options = $serviceLocator->get('OAuth2Provider/Options/ResponseType/AuthorizationCode')->setFromArray($options);

            // check if there is a direct defined 'token storage'
            $authorizationCodeStorage = Utilities::storageLookup(
                $serverKey,
                $options->getAuthorizationCodeStorage() ?: $options->getStorage(),
                $serviceLocator->get('OAuth2Provider/Containers/StorageContainer'),
                $serviceLocator,
                AuthorizationCodeFactory::IDENTIFIER
            );

            if (empty($authorizationCodeStorage)) {
                throw new Exception\InvalidServerException(sprintf(
                    "Class '%s' error: storage of type '%s' is required for Authorization Code '%s'",
                    __METHOD__,
                    AuthorizationCodeFactory::IDENTIFIER,
                    $authorizationCodeClassName
                ));
            }

            return new $authorizationCodeClassName($authorizationCodeStorage, $options->getConfigs());
        };
    }
}
