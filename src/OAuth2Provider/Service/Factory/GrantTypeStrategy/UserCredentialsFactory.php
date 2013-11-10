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
        return function ($grantTypeClassName, $params, $serverKey) use ($serviceLocator) {
            // look for a storage param
            if (isset($params['storage'])) {
                $storageName = $params['storage'];
                $storageContainer = $serviceLocator->get('OAuth2Provider/Containers/StorageContainer');

                // check if there is a direct defined storage key
                } elseif ($storageContainer->isServerContentsFromKey($serverKey, $storageName))  {
                    $storage = $storageContainer->getServerContentsFromKey($serverKey, $storageName);
                } elseif ($storageContainer->isServerContentsFromKey($serverKey, UserCredentialsFactory::IDENTIFIER)) {
                    $storage = $storageContainer->getServerContentsFromKey($serverKey, UserCredentialsFactory::IDENTIFIER);
                } elseif (is_string($storageName) && $serviceLocator->has($storageName)) {
                    $storage = $serviceLocator->get($storageName);
                } elseif (is_object($storageName)) {
                    $storage = $storageName;
                }

            }


            $storage = $storageContainer->getServerContentsFromKey($serverKey, UserCredentialsFactory::IDENTIFIER);


            var_dump($storage);die;

            $GrantTypeContainer = $serviceLocator->get('OAuth2Provider/Containers/GrantTypeContainer');
            $GrantTypeContainer[$serverKey][$storageName] = $grantTypeObj;

            return $grantTypeObj;
        };
    }
}
