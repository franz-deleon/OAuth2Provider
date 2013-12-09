<?php
namespace OAuth2Provider\Service\Factory\GrantTypeStrategy;

use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager;

class UserCredentialsFactory implements ServiceManager\FactoryInterface
{
    const IDENTIFIER = 'user_credentials';

    /**
     * Initialize an OAuth storage object
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($grantTypeClassName, $options, $serverKey) use ($serviceLocator) {

            $options = $serviceLocator->get('OAuth2Provider/Options/GrantType/UserCredentials')->setFromArray($options);

            $storage = Utilities::storageLookup(
                $serverKey,
                $options->getUserCredentialsStorage() ?: $options->getStorage(),
                $serviceLocator->get('OAuth2Provider/Containers/StorageContainer'),
                $serviceLocator,
                UserCredentialsFactory::IDENTIFIER
            );

            if (empty($storage)) {
                throw new Exception\InvalidServerException(sprintf(
                    "Class '%s' error: storage of type '%s' is required for grant type '%s'",
                    __METHOD__,
                    UserCredentialsFactory::IDENTIFIER,
                    $grantTypeClassName
                ));
            }

            return new $grantTypeClassName($storage);
        };
    }
}
