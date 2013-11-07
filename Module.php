<?php
namespace ApiOAuthProvider;

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
                'OAuthController' => 'ApiOAuthProvider\Service\Factory\ControllerFactory',
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                //'ApiOAuthProvider\StorageAdapter\ClientCredentials' => __NAMESPACE__ . '\StorageAdapter\ClientCredentials',
            ),
            'factories' => array(
                'ApiOAuthProvider\Options\Configuration'             => 'ApiOAuthProvider\Service\Factory\ConfigurationFactory',
                'ApiOAuthProvider\Service\Factory\MainServerFactory' => 'ApiOAuthProvider\Service\Factory\MainServerFactory',
                //'ApiOAuthProvider\Server' => 'ApiOAuthProvider\StorageAdapter\ServerFactory',
            ),
            'abstract_factories' => array(
                'ApiOAuthProvider\Service\AbstractFactory\ServerAbstractFactory',
            ),
            'aliases' => array(
                'apioauthprovider.server.main' => 'ApiOAuthProvider\Service\Factory\MainServerFactory',
            ),
        );
    }
}
