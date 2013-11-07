<?php
namespace ApiOAuthProvider\Service\Factory;

use ApiOAuthProvider\Options;
use ApiOAuthProvider\Exception;

use Zend\ServiceManager;

class ConfigurationFactory implements ServiceManager\FactoryInterface
{
    protected $serviceLocator;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        if (!isset($config['api_oauth_provider'])) {
            throw new Exception\InvalidConfigException(sprintf(
                "Class '%s' error: config api_oauth_provider does not exist.",
                __CLASS__ . ":" . __METHOD__
            ));
        }

        return new Options\Configuration($config['api_oauth_provider']);
    }
}
