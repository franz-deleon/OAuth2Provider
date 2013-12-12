<?php
namespace OAuth2Provider\Service\Factory\ClientAssertionTypeStrategy;

use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager;

class HttpBasicFactory implements ServiceManager\FactoryInterface
{
    /**
     * Strategy identifier
     * @var string
     */
    const IDENTIFIER = 'http_basic';

    /**
     * Storage identifier
     * @var string
     */
    const HTTP_BASIC_IDENTIFIER = 'client_credentials';

    /**
     * Initialize an OAuth storage object
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($className, $options, $serverKey) use ($serviceLocator) {

            $options = $serviceLocator->get('OAuth2Provider/Options/ClientAssertionType/HttpBasic')->setFromArray($options);
            $configs = $options->getConfigs();

            $storage = Utilities::storageLookup(
                $serverKey,
                $options->getClientCredentialsStorage() ?: $options->getStorage(),
                $serviceLocator->get('OAuth2Provider/Containers/StorageContainer'),
                $serviceLocator,
                HttpBasicFactory::HTTP_BASIC_IDENTIFIER
            );

            if (empty($storage)) {
                throw new Exception\InvalidServerException(sprintf(
                    "Class '%s' error: storage of type '%s' is required for Http Basic '%s'",
                    __METHOD__,
                    HttpBasicFactory::IDENTIFIER,
                    $className
                ));
            }

            return new $className($storage, $configs);
        };
    }
}
