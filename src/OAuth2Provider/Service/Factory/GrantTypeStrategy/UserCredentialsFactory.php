<?php
namespace OAuth2Provider\Service\Factory\GrantTypeStrategy;

use OAuth2Provider\Exception;
use OAuth2Provider\Options\GrantType\UserCredentialsConfigurations;
use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager;

class UserCredentialsFactory implements ServiceManager\FactoryInterface
{
    const USER_CREDENTIALS_IDENTIFIER = 'user_credentials';

    /**
     * Initialize an OAuth storage object
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($grantTypeClassName, $params, $serverKey) use ($serviceLocator) {

            $config = new UserCredentialsConfigurations($params);

            $storage = Utilities::storageLookup(
                $serverKey,
                $config->getUserCredentialsStorage() ?: $config->getStorage(),
                $serviceLocator->get('OAuth2Provider/Containers/StorageContainer'),
                $serviceLocator,
                UserCredentialsFactory::USER_CREDENTIALS_IDENTIFIER
            );

            if (!isset($storage)) {
                throw new Exception\InvalidServerException(sprintf(
                    "Class '%s' error: storage of type '%s' is required for grant type '%s'",
                    __METHOD__,
                    UserCredentialsFactory::USER_CREDENTIALS_IDENTIFIER,
                    $grantTypeClassName
                ));
            }

            return new $grantTypeClassName($storage);
        };
    }
}
