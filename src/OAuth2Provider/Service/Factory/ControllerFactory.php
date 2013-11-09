<?php
namespace OAuth2Provider\Service\Factory;

use OAuth2Provider\Exception;

use Zend\ServiceManager;

class ControllerFactory implements ServiceManager\FactoryInterface
{
    /**
     * List of available OAuth2 controllers
     * @var array
     */
    protected $availableControllers = array(
        'OAuth2Provider\Controller\UserCredentialsController',
    );

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

        // check for valid controller
        if (!in_array($controller, $this->availableControllers)) {
            throw new Exception\InvalidConfigException(sprintf(
                "Class '%s': controller '%s' does not exist",
                __CLASS__ . ":" . __METHOD__,
                $controller
            ));
        }

        return new $controller();
    }
}
