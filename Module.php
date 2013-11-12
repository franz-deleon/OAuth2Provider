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
                'OAuth2Provider/Containers/StorageContainer'      => 'OAuth2Provider\Containers\StorageContainer',
                'OAuth2Provider/Containers/ConfigContainer'       => 'OAuth2Provider\Containers\ConfigContainer',
                'OAuth2Provider/Containers/GrantTypeContainer'    => 'OAuth2Provider\Containers\GrantTypeContainer',
                'OAuth2Provider/Containers/ResponseTypeContainer' => 'OAuth2Provider\Containers\ResponseTypeContainer',
            ),
            'factories' => array(
                'OAuth2Provider/Options/Configuration' => 'OAuth2Provider\Service\Factory\ConfigurationFactory',

                /** Standard factories **/
                'OAuth2Provider/Service/MainServerFactory' => 'OAuth2Provider\Service\Factory\MainServerFactory',

                /** Server Features **/
                'OAuth2Provider/Service/ServerFeature/StorageFactory'      => 'OAuth2Provider\Service\Factory\ServerFeature\StorageFactory',
                'OAuth2Provider/Service/ServerFeature/GrantTypeFactory'    => 'OAuth2Provider\Service\Factory\ServerFeature\GrantTypeFactory',
                'OAuth2Provider/Service/ServerFeature/ConfigFactory'       => 'OAuth2Provider\Service\Factory\ServerFeature\ConfigFactory',
                'OAuth2Provider/Service/ServerFeature/ResponseTypeFactory' => 'OAuth2Provider\Service\Factory\ServerFeature\ResponseTypeFactory',

                /** Grant Type Strategies **/
                'OAuth2Provider/GrantTypeStrategy/AuthorizationCode' => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\AuthorizationCodeFactory',
                'OAuth2Provider/GrantTypeStrategy/ClientCredentials' => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\ClientCredentialsFactory',
                'OAuth2Provider/GrantTypeStrategy/JwtBearer'         => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\JwtBearerFactory',
                'OAuth2Provider/GrantTypeStrategy/RefreshToken'      => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\RefreshTokenFactory' ,
                'OAuth2Provider/GrantTypeStrategy/UserCredentials'   => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\UserCredentialsFactory',

                /** Response Type Strategies **/
                'OAuth2Provider/GrantTypeStrategy/AccessToken'       => 'OAuth2Provider\Service\Factory\ResponseTypeStrategy\AccessTokenFactory',
                'OAuth2Provider/GrantTypeStrategy/AuthorizationCode' => 'OAuth2Provider\Service\Factory\ResponseTypeStrategy\AuthorizationCodeFactory',
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
