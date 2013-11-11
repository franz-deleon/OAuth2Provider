<?php
namespace OAuth2Provider\Service\Factory;

use OAuth2Provider\Options;
use OAuth2Provider\Exception;

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

        if (!isset($config['oauth2provider'])) {
            throw new Exception\InvalidConfigException(sprintf(
                "Class '%s' error: config api_oauth_provider does not exist.",
                __CLASS__ . ":" . __METHOD__
            ));
        }

        return new Options\Configuration($config['oauth2provider']);
    }
}
