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

    public function getModuleDependencies()
    {
        return array(
            'DoctrineORMModule'
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
                //'OAuth2Provider\StorageAdapter\ClientCredentials' => __NAMESPACE__ . '\StorageAdapter\ClientCredentials',
            ),
            'factories' => array(
                'OAuth2Provider\Options\Configuration'             => 'OAuth2Provider\Service\Factory\ConfigurationFactory',
                'OAuth2Provider\Service\Factory\MainServerFactory' => 'OAuth2Provider\Service\Factory\MainServerFactory',
                //'OAuth2Provider\Server' => 'OAuth2Provider\StorageAdapter\ServerFactory',
            ),
            'abstract_factories' => array(
                'OAuth2Provider\Service\AbstractFactory\ServerAbstractFactory',
            ),
            'aliases' => array(
                'oauth2provider.server.main' => 'OAuth2Provider\Service\Factory\MainServerFactory',
            ),
        );
    }
}
