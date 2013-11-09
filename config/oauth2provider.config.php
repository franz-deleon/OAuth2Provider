<?php
return array(
    /**
     * Servers
     *
     * Grant Type keys:
     * 1. authorization_code
     * 2. client_credentials
     * 3. jwt_bearer
     * 4. refresh_token
     * 5. user_credentials
     *
     * OAuth 2 server list and configurations
     */
    'servers' => array(
        'default' => array(
            'storages' => array(
                'user_credentials' => new \stdClass(),
                'authorization_code' => new \stdClass(),
            ),
            'grant_types' => array(
                //'user_credentials' => 'OAuth2\GrantType\UserCredentials',
                'OAuth2Provider\UserCreds',
                'OAuth2\GrantType\UserCredentials',
                array(
                    'class' => 'OAuth2Provider\GrantType\UserCredentials',
                    'params' => array(
                        'storage' => 'user_credentials',
                    ),
                ),
            ),
        ),
    ),

    /**
     * Main Primary Server
     *
     * Define by picking the "main server" to use from server configuration list above.
     * Default: default
     */
    'main_server' => '',

    /**
     * Controller
     *
     * Define which controller to use
     */
    'controller' => 'OAuth2Provider\Controller\UserCredentialsController',
);
