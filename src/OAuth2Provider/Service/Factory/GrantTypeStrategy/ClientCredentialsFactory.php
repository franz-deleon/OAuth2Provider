<?php
namespace OAuth2Provider\Service\Factory\GrantTypeStrategy;

use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager;

class ClientCredentialsFactory implements ServiceManager\FactoryInterface
{
    const IDENTIFIER = 'client_credentials';

    /**
     * Initialize an OAuth storage object
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($clientCredentialsClassName, $options, $serverKey) use ($serviceLocator) {

            $options = $serviceLocator->get('OAuth2Provider/Options/GrantType/ClientCredentials')->setFromArray($options);

            $storage = Utilities::storageLookup(
                $serverKey,
                $options->getClientCredentialsStorage() ?: $options->getStorage(),
                $serviceLocator->get('OAuth2Provider/Containers/StorageContainer'),
                $serviceLocator,
                ClientCredentialsFactory::IDENTIFIER
            );

            if (empty($storage)) {
                throw new Exception\InvalidServerException(sprintf(
                    "Class '%s' error: storage of type '%s' is required for grant type '%s'",
                    __METHOD__,
                    ClientCredentialsFactory::IDENTIFIER,
                    $clientCredentialsClassName
                ));
            }

            return new $clientCredentialsClassName($storage, $options->getConfigs());
        };
    }
}
