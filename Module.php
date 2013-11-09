<?php
namespace OAuth2Provider;

class Module
{
    public function onBootstrap($mvcEvent)
    {

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'OAuthController' => 'OAuth2Provider\Service\Factory\ControllerFactory',
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'OAuth2Provider/Containers/StorageContainer' => 'OAuth2Provider\Containers\StorageContainer',
                'OAuth2Provider/Containers/GrantTypeContainer' => 'OAuth2Provider\Containers\GrantTypeContainer',
            ),
            'factories' => array(
                'OAuth2Provider/Options/Configuration' => 'OAuth2Provider\Service\Factory\ConfigurationFactory',
                'OAuth2Provider/Service/MainServerFactory' => 'OAuth2Provider\Service\Factory\MainServerFactory',
                'OAuth2Provider/Service/StorageFactory' => 'OAuth2Provider\Service\Factory\StorageFactory',
                'OAuth2Provider/Service/GrantTypeFactory' => 'OAuth2Provider\Service\Factory\GrantTypeFactory',
            ),
            'abstract_factories' => array(
                'OAuth2Provider\Service\AbstractFactory\ServerAbstractFactory',
            ),
            'aliases' => array(
                'oauth2provider.server.main' => 'OAuth2Provider/Service/MainServerFactory',
            ),
        );
    }
}
