<?php
return array(
    /**
     * The module works by asking you to define how you create your OAuth 2 Server.
     * OAuth2Provider module will do its best to map grant types, response type, etc
     * that you wish to use for a specific storage.
     *
     * Refer to the strategies on how this works. Each of these features gets mapped
     * to a specific stategy. Available strategies can be found at:
     * OAuth2Provider\Factory\*TypeStrategy
     *
     * In addition, refer to https://github.com/bshaffer/oauth2-server-php
     * if you have no idea what an OAuth 'server' is :)
     *
     * In a nutshell, all you have to do is define your storages in the 'storages' configuration.
     * The storages will accept php objects or Service Manager, or callbacks
     * with an injected service manager (function ($sm) {}).
     *
     * The available configuration keys provided for 'servers' are:
     *
     * a. storages
     * b. configs
     * c. grant_types
     * d. response_types
     * e. token_type
     * f. scope_util
     * g. client_assertion_type
     *
     * You can view the list of configurations in: OAuth2Provider\Options\ServerConfigurations
     */
    'servers' => array(
        'default' => array(
            'storages' => array(
                'user_credentials' => new \OAuth2ProviderTests\Assets\Storage\UserCredentialsStorage(),
                'access_token'  => new \OAuth2ProviderTests\Assets\Storage\AccessTokenStorage(),
                'refresh_token' => function ($sm) {
                    $x = new \OAuth2ProviderTests\Assets\Storage\RefreshTokenStorage();
                    return $x;
                }
            ),
            'configs' => array(
                'www_realm'                  => 'Service',
                'token_param_name'           => 'access_token',
                'token_bearer_header_name'   => 'Bearer',
            ),
            'grant_types' => array(
                //'user_credentials' => 'OAuth2\GrantType\UserCredentials',
                //'OAuth2Provider\UserCreds',
                //'OAuth2\GrantType\UserCredentials',
                array(
                    'name' => 'OAuth2\GrantType\UserCredentials',
                    'params' => array(
                        //'storage' => 'user_credentials',
                    ),
                ),
            ),
            'response_types' => array(
                array(
                    'name' => 'OAuth2\ResponseType\AccessToken',
                    'params' => array(
                        //'token_storage' => 'access_token',
                        //'refresh_storage' => 'refresh_token',
                        'config' => array(

                        ),
                    ),
                ),
            ),
        ),
    ),

    /**
     * Main Primary Server
     *
     * Define by picking the "main server" to use from the server configurations list/keys above.
     * You can access the main server using the through the main service manager by:
     *
     * <code>
     * $sm->get('oauth2provider.server.main');
     * </code>
     *
     * Defaults to: default
     */
    'main_server' => '',

    /**
     * Controller
     *
     * Define which controller to use:
     */
    'controller' => 'OAuth2Provider\Controller\UserCredentialsController',
);
