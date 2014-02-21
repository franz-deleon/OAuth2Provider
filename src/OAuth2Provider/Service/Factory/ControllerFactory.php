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

        // check for a specific defined server controller
        $servers   = $configuration->getServers();
        $serverKey = $configuration->getMainServer();
        if (isset($servers[$serverKey]['controller'])) {
            $controller = $servers[$serverKey]['controller'];
        } else {
            $mvcEvent = $serviceLocator->getServiceLocator()->get('Application')->getMvcEvent();
            if (isset($mvcEvent) && null !== $mvcEvent->getRouteMatch()) {
                $version = $mvcEvent->getRouteMatch()->getParam('version');
            }
            if (empty($version)) {
                $version = $configuration->getMainVersion();
            }

            if (isset($servers[$serverKey])) {
                foreach ($servers[$serverKey] as $server) {
                    // fix for php 5.3 bug which isset outputs true if var is string
                    if (is_array($server) && !empty($server['controller'])
                        && (!empty($server['version']) && $server['version'] === $version)
                    ) {
                        $controller = $server['controller'];
                        break;
                    }
                }
            }
        }

        if (empty($controller)) {
            $controller = $configuration->getDefaultController();
        }

        $controller = new $controller();

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
