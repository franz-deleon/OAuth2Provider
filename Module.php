<?php
namespace OAuth2Provider;

class Module
{
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
                    'OAuth2ProviderTests' => __DIR__ . '/tests/OAuth2ProviderTests',
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'OAuth2Provider/Service/ServerFeature/StrategyBuilder' => function () {
                    return function ($strategyTypes, $serverKey, $strategies, $concreteClasses, $container) {
                        return new OAuth2Provider\Service\Factory\ServerFeature\StrategyBuilder(
                            $strategyTypes, $serverKey, $strategies, $concreteClasses, $container
                        );
                    };
                },
            ),
            'shared' => array(
                'OAuth2Provider/Service/ServerFeature/StrategyBuilder' => false,
            ),
        );
    }
}
