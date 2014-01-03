<?php
namespace OAuth2Provider\Service\Factory;

use OAuth2Provider\Exception;
use OAuth2Provider\Controller\ControllerInterface;

use Zend\ServiceManager;

class ControllerFactory implements ServiceManager\FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $configuration = $serviceLocator->getServiceLocator()->get('OAuth2Provider/Options/Configuration');
        $controller    = $configuration->getController();
        $controller    = new $controller();

        // check for valid controller
        if (!$controller instanceof ControllerInterface) {
            throw new Exception\InvalidConfigException(sprintf(
                "Class '%s': controller '%s' is not an intance of ControllerInterface",
                __CLASS__ . ":" . __METHOD__,
                get_class($controller)
            ));
        }

        return $controller;
    }
}
