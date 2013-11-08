<?php
namespace OAuth2Provider\Service\AbstractFactory;

use OAuth2Provider\Exception;
use Zend\ServiceManager;

class ServerAbstractFactory implements ServiceManager\AbstractFactoryInterface
{
    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceManager\ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (0 === strpos($requestedName, 'oauth2provider.server.')) {
            $serverKey = substr($requestedName, strrpos($requestedName, '.') + 1);
            $serverConfigs = $serviceLocator->get('OAuth2Provider\Options\Configuration')->getServer();

            if (isset($serverConfigs[$serverKey])) {
                return true;
            }

            throw new Exception\InvalidServerException(sprintf(
                "Class '%s' error: server configuration '%s' does not exist",
                __METHOD__,
                $serverKey
            ));
        }

        return false;
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     */
    public function createServiceWithName(ServiceManager\ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return new \stdClass();
    }
}
