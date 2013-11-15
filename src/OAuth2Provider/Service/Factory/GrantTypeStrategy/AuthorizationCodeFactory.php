<?php
namespace OAuth2Provider\Service\Factory\GrantTypeStrategy;

use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager;

class AuthorizationCodeFactory implements ServiceManager\FactoryInterface
{
    const AUTHORIZATION_CODE_IDENTIFIER = 'authorization_code';

    /**
     * Initialize an OAuth storage object
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($authorizationCodeClassName, $options, $serverKey) use ($serviceLocator) {

            $config = $serviceLocator->get('OAuth2Provider/Options/GrantType/AuthorizationCode')
                ->setFromArray($options);

            $storage = Utilities::storageLookup(
                $serverKey,
                $config->getAuthorizationCodeStorage() ?: $config->getStorage(),
                $serviceLocator->get('OAuth2Provider/Containers/StorageContainer'),
                $serviceLocator,
                AuthorizationCodeFactory::AUTHORIZATION_CODE_IDENTIFIER
            );

            if (empty($storage)) {
                throw new Exception\InvalidServerException(sprintf(
                    "Class '%s' error: storage of type '%s' is required for grant type '%s'",
                    __METHOD__,
                    AuthorizationCodeFactory::AUTHORIZATION_CODE_IDENTIFIER,
                    $authorizationCodeClassName
                ));
            }

            return new $authorizationCodeClassName($storage);
        };
    }
}
