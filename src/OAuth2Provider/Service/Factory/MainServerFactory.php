<?php
namespace OAuth2Provider\Service\Factory;

use Zend\ServiceManager;

class MainServerFactory implements ServiceManager\FactoryInterface
{
    /**
     * Initialized the Main Server used by the controllers
     *
     * The main server call is: oauth2provider.server.main
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $configuration = $serviceLocator->get('OAuth2Provider/Options/Configuration');

        // initialize the main server via the abstract server factory;
        return $serviceLocator->get('oauth2provider.server.' . $configuration->getMainServer());
    }
}
