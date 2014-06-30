<?php
return array(
    'service_manager' => array(
        'invokables' => array(
            /** Containers **/
            'OAuth2Provider/Containers/StorageContainer'         => 'OAuth2Provider\Containers\StorageContainer',
            'OAuth2Provider/Containers/ConfigContainer'          => 'OAuth2Provider\Containers\ConfigContainer',
            'OAuth2Provider/Containers/GrantTypeContainer'       => 'OAuth2Provider\Containers\GrantTypeContainer',
            'OAuth2Provider/Containers/ResponseTypeContainer'    => 'OAuth2Provider\Containers\ResponseTypeContainer',
            'OAuth2Provider/Containers/TokenTypeContainer'       => 'OAuth2Provider\Containers\TokenTypeContainer',
            'OAuth2Provider/Containers/ScopeTypeContainer'       => 'OAuth2Provider\Containers\ScopeTypeContainer',
            'OAuth2Provider/Containers/ClientAssertionContainer' => 'OAuth2Provider\Containers\ClientAssertionTypeContainer',
            'OAuth2Provider/Containers/RequestContainer'         => 'OAuth2Provider\Containers\RequestContainer',
            'OAuth2Provider/Containers/ResponseContainer'        => 'OAuth2Provider\Containers\ResponseContainer',

            /** Options configurations **/
            'OAuth2Provider/Options/Server'            => 'OAuth2Provider\Options\ServerConfigurations',
            'OAuth2Provider/Options/ServerFeatureType' => 'OAuth2Provider\Options\ServerFeatureTypeConfiguration',
            'OAuth2Provider/Options/TypeAbstract'      => 'OAuth2Provider\Options\TypeAbstract',
            'OAuth2Provider/Options/GrantType/UserCredentials'      => 'OAuth2Provider\Options\GrantType\UserCredentialsConfigurations',
            'OAuth2Provider/Options/GrantType/RefreshToken'         => 'OAuth2Provider\Options\GrantType\RefreshTokenConfigurations',
            'OAuth2Provider/Options/GrantType/ClientCredentials'    => 'OAuth2Provider\Options\GrantType\ClientCredentialsConfigurations',
            'OAuth2Provider/Options/GrantType/AuthorizationCode'    => 'OAuth2Provider\Options\GrantType\AuthorizationCodeConfigurations',
            'OAuth2Provider/Options/ResponseType/AccessToken'       => 'OAuth2Provider\Options\ResponseType\AccessTokenConfigurations',
            'OAuth2Provider/Options/ResponseType/AuthorizationCode' => 'OAuth2Provider\Options\ResponseType\AuthorizationCodeConfigurations',
            'OAuth2Provider/Options/TokenType/Bearer' => 'OAuth2Provider\Options\TokenType\BearerConfigurations',
            'OAuth2Provider/Options/ScopeType/Scope'  => 'OAuth2Provider\Options\ScopeType\ScopeConfigurations',
            'OAuth2Provider/Options/ClientAssertionType/HttpBasic'  => 'OAuth2Provider\Options\ClientAssertionType\HttpBasicConfigurations',
        ),
        'factories' => array(
            /** Main Options Configuration (oauth2provider.config.php) **/
            'OAuth2Provider/Options/Configuration' => 'OAuth2Provider\Service\Factory\ConfigurationFactory',

            /** Standard factories **/
            'OAuth2Provider/Service/MainServerFactory' => 'OAuth2Provider\Service\Factory\MainServerFactory',

            /** Server Features **/
            'OAuth2Provider/Service/ServerFeature/StorageFactory' => 'OAuth2Provider\Service\Factory\ServerFeature\StorageFactory',
            'OAuth2Provider/Service/ServerFeature/ConfigFactory'  => 'OAuth2Provider\Service\Factory\ServerFeature\ConfigFactory',

            /**
             * Strategy based Server Feature Factories
             * You can use specific Server base feature strategies from the numbered list below
             */
            'OAuth2Provider/Service/ServerFeature/GrantTypeFactory'    => 'OAuth2Provider\Service\Factory\ServerFeature\GrantTypeFactory',
            'OAuth2Provider/Service/ServerFeature/ResponseTypeFactory' => 'OAuth2Provider\Service\Factory\ServerFeature\ResponseTypeFactory',
            'OAuth2Provider/Service/ServerFeature/TokenTypeFactory'    => 'OAuth2Provider\Service\Factory\ServerFeature\TokenTypeFactory',
            'OAuth2Provider/Service/ServerFeature/ScopeTypeFactory'    => 'OAuth2Provider\Service\Factory\ServerFeature\ScopeTypeFactory',
            'OAuth2Provider/Service/ServerFeature/ClientAssertionTypeFactory' => 'OAuth2Provider\Service\Factory\ServerFeature\ClientAssertionTypeFactory',

            /**
             * Available Server based Feature Strategies
             * Below are the list of available strategies for Server based features
             */

            /** 1. Grant Type Strategies (OAuth2Provider/Service/ServerFeature/GrantTypeFactory) **/
            'OAuth2Provider/GrantTypeStrategy/AuthorizationCode' => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\AuthorizationCodeFactory',
            'OAuth2Provider/GrantTypeStrategy/ClientCredentials' => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\ClientCredentialsFactory',
            'OAuth2Provider/GrantTypeStrategy/JwtBearer'         => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\JwtBearerFactory',
            'OAuth2Provider/GrantTypeStrategy/RefreshToken'      => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\RefreshTokenFactory' ,
            'OAuth2Provider/GrantTypeStrategy/UserCredentials'   => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\UserCredentialsFactory',

            /** 2. Response Type Strategies (OAuth2Provider/Service/ServerFeature/ResponseTypeFactory) **/
            'OAuth2Provider/GrantTypeStrategy/AccessToken'       => 'OAuth2Provider\Service\Factory\ResponseTypeStrategy\AccessTokenFactory',
            'OAuth2Provider/GrantTypeStrategy/AuthorizationCode' => 'OAuth2Provider\Service\Factory\ResponseTypeStrategy\AuthorizationCodeFactory',

            /** 3. Token Type Strategies (OAuth2Provider/Service/ServerFeature/TokenTypeFactory) **/
            'OAuth2Provider/TokenTypeStrategy/Bearer' => 'OAuth2Provider\Service\Factory\TokenTypeStrategy\BearerFactory',
            // todo: implement mac strategy when implemented in OAuth2

            /** 4. Scope Strategies (OAuth2Provider/Service/ServerFeature/ScopeFactory) **/
            'OAuth2Provider/ScopeStrategy/Scope' => 'OAuth2Provider\Service\Factory\ScopeStrategy\ScopeFactory',

            /** 5. Client Assertion Type Strategies (OAuth2Provider/Service/ServerFeature/ClientAssertionTypeFactory) **/
            'OAuth2Provider/ClientAssertionStrategy/HttpBasic' => 'OAuth2Provider\Service\Factory\ClientAssertionTypeStrategy\HttpBasicFactory',
        ),
        'abstract_factories' => array(
            'OAuth2Provider\Service\AbstractFactory\ServerAbstractFactory',
            'OAuth2Provider\Service\AbstractFactory\RequestAbstractFactory',
            'OAuth2Provider\Service\AbstractFactory\ResponseAbstractFactory',
            'OAuth2Provider\Service\AbstractFactory\ContainerAbstractFactory',
        ),
        'aliases' => array(
            'oauth2provider.server.main' => 'OAuth2Provider/Service/MainServerFactory',
        ),
        'shared' => array(
            /** We do not share options as it is unique to each object **/
            'OAuth2Provider/Options/ServerFeatureType'              => false,
            'OAuth2Provider/Options/TypeAbstract'                   => false,
            'OAuth2Provider/Options/Server'                         => false,
            'OAuth2Provider/Options/GrantType/UserCredentials'      => false,
            'OAuth2Provider/Options/GrantType/RefreshToken'         => false,
            'OAuth2Provider/Options/GrantType/ClientCredentials'    => false,
            'OAuth2Provider/Options/GrantType/AuthorizationCode'    => false,
            'OAuth2Provider/Options/ResponseType/AccessToken'       => false,
            'OAuth2Provider/Options/ResponseType/AuthorizationCode' => false,
            'OAuth2Provider/Options/TokenType/Bearer'               => false,
            'OAuth2Provider/Options/ScopeType/Scope'                => false,
            'OAuth2Provider/Options/ClientAssertionType/HttpBasic'  => false,
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'OAuthController' => 'OAuth2Provider\Service\Factory\ControllerFactory',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'oauth2provider' => array(
        'default_controller' => 'OAuth2Provider\Controller\UserCredentialsController',
    ),
    'router'         => include __DIR__ . '/routes.config.php',
);