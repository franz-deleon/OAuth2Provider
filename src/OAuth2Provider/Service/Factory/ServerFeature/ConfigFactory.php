<?php
namespace OAuth2Provider\Service\Factory\ServerFeature;

use Zend\ServiceManager;

class ConfigFactory implements ServiceManager\FactoryInterface
{
    /**
     * For reference only
     * @var array
     */
    protected $defaultConfigs = array(
        'access_lifetime'            => 3600,
        'www_realm'                  => 'Service',
        'token_param_name'           => 'access_token',
        'token_bearer_header_name'   => 'Bearer',
        'enforce_state'              => true,
        'require_exact_redirect_uri' => true,
        'allow_implicit'             => false,
        'allow_credentials_in_request_body' => true,
    );

    /**
     * Store config information
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($configs, $serverKey) use ($serviceLocator) {
            $configContainer = $serviceLocator->get('OAuth2Provider/Containers/ConfigContainer');
            $configContainer[$serverKey] = $configs;

            return $configContainer->getServerContents($serverKey);
        };
    }
}
