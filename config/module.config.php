<?php
return array(
    'service_manager' => array(
        'invokables' => array(
            /** Containers **/
            'OAuth2Provider/Containers/StorageContainer'      => 'OAuth2Provider\Containers\StorageContainer',
            'OAuth2Provider/Containers/ConfigContainer'       => 'OAuth2Provider\Containers\ConfigContainer',
            'OAuth2Provider/Containers/GrantTypeContainer'    => 'OAuth2Provider\Containers\GrantTypeContainer',
            'OAuth2Provider/Containers/ResponseTypeContainer' => 'OAuth2Provider\Containers\ResponseTypeContainer',
            'OAuth2Provider/Containers/TokenTypeContainer'    => 'OAuth2Provider\Containers\TokenTypeContainer',

            /** Options configurations **/
            'OAuth2Provider/Options/Server'            => 'OAuth2Provider\Options\ServerConfigurations',
            'OAuth2Provider/Options/ServerFeatureType' => 'OAuth2Provider\Options\ServerFeatureTypeConfiguration',
            'OAuth2Provider/Options/TypeAbstract'      => 'OAuth2Provider\Options\TypeAbstract',
            'OAuth2Provider/Options/GrantType/UserCredentials' => 'OAuth2Provider\Options\GrantType\UserCredentialsConfigurations',
            'OAuth2Provider/Options/ResponseType/AccessToken'  => 'OAuth2Provider\Options\ResponseType\AccessTokenConfigurations',
            'OAuth2Provider/Options/ResponseType/AuthorizationCode' => 'OAuth2Provider\Options\ResponseType\AuthorizationCodeConfigurations',
            'OAuth2Provider/Options/TokenType/Bearer' => 'OAuth2Provider\Options\TokenType\BearerConfigurations',
        ),
        'factories' => array(
            /** Main Options Configuration (oauth2provider.config.php) **/
            'OAuth2Provider/Options/Configuration' => 'OAuth2Provider\Service\Factory\ConfigurationFactory',

            /** Standard factories **/
            'OAuth2Provider/Service/MainServerFactory' => 'OAuth2Provider\Service\Factory\MainServerFactory',

            /** Server Features **/
            'OAuth2Provider/Service/ServerFeature/StorageFactory' => 'OAuth2Provider\Service\Factory\ServerFeature\StorageFactory',
            'OAuth2Provider/Service/ServerFeature/ConfigFactory'  => 'OAuth2Provider\Service\Factory\ServerFeature\ConfigFactory',

            /** Strategy based Server Features **/
            'OAuth2Provider/Service/ServerFeature/GrantTypeFactory'    => 'OAuth2Provider\Service\Factory\ServerFeature\GrantTypeFactory',
            'OAuth2Provider/Service/ServerFeature/ResponseTypeFactory' => 'OAuth2Provider\Service\Factory\ServerFeature\ResponseTypeFactory',
            'OAuth2Provider/Service/ServerFeature/TokenTypeFactory'    => 'OAuth2Provider\Service\Factory\ServerFeature\TokenTypeFactory',

            /** Grant Type Strategies - OAuth2Provider/Service/ServerFeature/GrantTypeFactory **/
            'OAuth2Provider/GrantTypeStrategy/AuthorizationCode' => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\AuthorizationCodeFactory',
            'OAuth2Provider/GrantTypeStrategy/ClientCredentials' => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\ClientCredentialsFactory',
            'OAuth2Provider/GrantTypeStrategy/JwtBearer'         => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\JwtBearerFactory',
            'OAuth2Provider/GrantTypeStrategy/RefreshToken'      => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\RefreshTokenFactory' ,
            'OAuth2Provider/GrantTypeStrategy/UserCredentials'   => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\UserCredentialsFactory',

            /** Response Type Strategies - OAuth2Provider/Service/ServerFeature/ResponseTypeFactory **/
            'OAuth2Provider/GrantTypeStrategy/AccessToken'       => 'OAuth2Provider\Service\Factory\ResponseTypeStrategy\AccessTokenFactory',
            'OAuth2Provider/GrantTypeStrategy/AuthorizationCode' => 'OAuth2Provider\Service\Factory\ResponseTypeStrategy\AuthorizationCodeFactory',

            /** Token Type Strategies - OAuth2Provider/Service/ServerFeature/TokenTypeFactory **/
            'OAuth2Provider/TokenTypeStrategy/Bearer' => 'OAuth2Provider\Service\Factory\TokenTypeStrategy\BearerFactory',
        ),
        'abstract_factories' => array(
            'OAuth2Provider\Service\AbstractFactory\ServerAbstractFactory',
            'OAuth2Provider\Service\AbstractFactory\GrantTypeAbstractFactory',
        ),
        'aliases' => array(
            'oauth2provider.server.main' => 'OAuth2Provider/Service/MainServerFactory',
        ),
        'shared' => array(
            'OAuth2Provider/Options/ServerFeatureType'         => false,
            'OAuth2Provider/Options/TypeAbstract'              => false,
            'OAuth2Provider/Options/Server'                    => false,
            'OAuth2Provider/Options/GrantType/UserCredentials' => false,
            'OAuth2Provider/Options/ResponseType/AccessToken'  => false,
            'OAuth2Provider/Options/ResponseType/AuthorizationCode' => false,
            'OAuth2Provider/Options/TokenType/Bearer'          => false,
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
    ),
    'oauth2provider' => include_once __DIR__ . '/OAuth2provider.config.php',
    'router'         => include_once __DIR__ . '/routes.config.php',
);