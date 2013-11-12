<?php
namespace OAuth2Provider\Service\Factory\ResponseTypeStrategy;

use OAuth2Provider\Exception;

use Zend\ServiceManager;

class AccessTokenFactory implements ServiceManager\FactoryInterface
{
    const IDENTIFIER = 'access_token';

    /**
     * Initialize an OAuth storage object
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($grantTypeClassName, $params, $serverKey) use ($serviceLocator) {

            $storageName = isset($params['access_token_storage']) ? $params['storage'] : null;
            $storageContainer = $serviceLocator->get('OAuth2Provider/Containers/StorageContainer');

            // check if there is a direct defined storage key
            if ($storageContainer->isExistingServerContentInKey($serverKey, $storageName))  {
                $storage = $storageContainer->getServerContentsFromKey($serverKey, $storageName);
            } elseif ($storageContainer->isExistingServerContentInKey($serverKey, AccessTokenFactory::IDENTIFIER)) {
                $storage = $storageContainer->getServerContentsFromKey($serverKey, AccessTokenFactory::IDENTIFIER);
            } elseif (is_string($storageName) && $serviceLocator->has($storageName)) {
                $storage = $serviceLocator->get($storageName);
            } elseif (is_object($storageName)) {
                $storage = $storageName;
            }

            if (!isset($storage)) {
                throw new Exception\InvalidServerException(sprintf(
                    "Class '%s' error: storage of type '%s' is required for grant type '%s'",
                    __METHOD__,
                    AccessTokenFactory::IDENTIFIER,
                    $grantTypeClassName
                ));
            }

            return new $grantTypeClassName($storage);
        };
    }
}
