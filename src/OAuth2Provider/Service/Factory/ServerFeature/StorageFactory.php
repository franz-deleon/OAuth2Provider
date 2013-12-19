<?php
namespace OAuth2Provider\Service\Factory\ServerFeature;

use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager;

class StorageFactory implements ServiceManager\FactoryInterface
{
    /**
     * Valid storage name keys
     * @var array
     */
    protected $storageNames = array(
        'access_token',
        'authorization_code',
        'client_credentials',
        'client',
        'refresh_token',
        'user_credentials',
        'jwt_bearer',
        'scope',
    );

    /**
     * Initialize an OAuth storage object
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $storageNames = $this->storageNames;
        return function ($storages, $serverKey) use ($serviceLocator, $storageNames) {

            $storageContainer = $serviceLocator->get('OAuth2Provider/Containers/StorageContainer');
            foreach ($storages as $storageName => $storage) {
                if (!in_array($storageName, $storageNames)) {
                    throw new Exception\InvalidConfigException(sprintf(
                        "Class '%s': the storage config '%s' is not valid",
                        __METHOD__,
                        $storageName
                    ));
                }

                $storageObj = Utilities::createClass($storage, $serviceLocator, sprintf(
                    "Class '%s' does not exist.",
                    is_object($storage) ? get_class($storage) : $storage
                ));
                $storageContainer[$serverKey][$storageName] = $storageObj;
            }

            return $storageContainer->getServerContents($serverKey);
        };
    }
}
