<?php
namespace OAuth2Provider\Service\Factory\GrantTypeStrategy;

use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager;

class AuthorizationCodeFactory implements ServiceManager\FactoryInterface
{
    const IDENTIFIER = 'authorization_code';

    /**
     * Initialize an OAuth storage object
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($authorizationCodeClassName, $options, $serverKey) use ($serviceLocator) {

            $options = $serviceLocator->get('OAuth2Provider/Options/GrantType/AuthorizationCode')
                ->setFromArray($options);

            $storage = Utilities::storageLookup(
                $serverKey,
                $options->getAuthorizationCodeStorage() ?: $options->getStorage(),
                $serviceLocator->get('OAuth2Provider/Containers/StorageContainer'),
                $serviceLocator,
                AuthorizationCodeFactory::IDENTIFIER
            );

            if (empty($storage)) {
                throw new Exception\InvalidServerException(sprintf(
                    "Class '%s' error: storage of type '%s' is required for grant type '%s'",
                    __METHOD__,
                    AuthorizationCodeFactory::IDENTIFIER,
                    $authorizationCodeClassName
                ));
            }

            return new $authorizationCodeClassName($storage);
        };
    }
}
