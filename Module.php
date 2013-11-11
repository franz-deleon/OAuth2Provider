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
                'OAuth2Provider/Containers/StorageContainer'   => 'OAuth2Provider\Containers\StorageContainer',
                'OAuth2Provider/Containers/GrantTypeContainer' => 'OAuth2Provider\Containers\GrantTypeContainer',
            ),
            'factories' => array(
                'OAuth2Provider/Options/Configuration'     => 'OAuth2Provider\Service\Factory\ConfigurationFactory',

                /** Standard factories **/
                'OAuth2Provider/Service/StorageFactory'    => 'OAuth2Provider\Service\Factory\StorageFactory',
                'OAuth2Provider/Service/MainServerFactory' => 'OAuth2Provider\Service\Factory\MainServerFactory',
                'OAuth2Provider/Service/GrantTypeFactory'  => 'OAuth2Provider\Service\Factory\GrantTypeFactory',

                /** Grant Type Strategies **/
                'OAuth2Provider/GrantTypeStrategy/AuthorizationCode' => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\AuthorizationCodeFactory',
                'OAuth2Provider/GrantTypeStrategy/ClientCredentials' => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\ClientCredentialsFactory',
                'OAuth2Provider/GrantTypeStrategy/JwtBearer'         => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\JwtBearerFactory',
                'OAuth2Provider/GrantTypeStrategy/RefreshToken'      => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\RefreshTokenFactory' ,
                'OAuth2Provider/GrantTypeStrategy/UserCredentials'   => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\UserCredentialsFactory',
            ),
            'abstract_factories' => array(
                'OAuth2Provider\Service\AbstractFactory\ServerAbstractFactory',
                'OAuth2Provider\Service\AbstractFactory\GrantTypeAbstractFactory',
            ),
            'aliases' => array(
                'oauth2provider.server.main' => 'OAuth2Provider/Service/MainServerFactory',
            ),
        );
    }
}
