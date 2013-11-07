<?php
namespace ApiOAuthProvider\Service\AbstractFactory;

use ApiOAuthProvider\Exception;
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
        if (0 === strpos($requestedName, 'apioauthprovider.server.')) {
            $serverKey = substr($requestedName, strrpos($requestedName, '.') + 1);
            $serverConfigs = $serviceLocator->get('ApiOAuthProvider\Options\Configuration')->getServer();

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
