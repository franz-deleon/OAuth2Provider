<?php
namespace OAuth2Provider\Factory\GrantTypeStrategy;

use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager;

class UserCredentialsFactory implements ServiceManager\FactoryInterface
{
    /**
     * Initialize an OAuth storage object
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($grantType, $grantTypeName, $serverKey) use ($serviceLocator) {
            // map the grant type to a strategy

            $storageContainer = $serviceLocator->get('OAuth2Provider/Containers/StorageContainer');
            $storageContainer[$serverKey][$storageName] = $storageObj;

            return $storageObj;
        };
    }
}
