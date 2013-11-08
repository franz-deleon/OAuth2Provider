<?php
return array(
    /**
     * Storages
     * OAuth 2 Storage list and configurations
     */
    'storage' => array(
        'access_token' => array(

        ),
        'authorization_code' => array(

        ),
        'client_credentials' => array(

        ),
        'client' => array(

        ),
        'jwt_bearer' => array(

        ),
        'memory' => array(

        ),
        'mongo' => array(

        ),
        'pdo' => array(

        ),
        'redis' => array(

        ),
        'refresh_token' => array(

        ),
        'scope' => array(

        ),
        'user_credentials' => array(

        ),
    ),

    /**
     * Grant Types
     * OAuth 2 Grant Type list and configurations
     */
    'grant_type' => array(
        'authorization_code' => array(

        ),
        'client_credentials' => array(

        ),
        'jwt_bearer' => array(

        ),
        'refresh_token' => array(

        ),
        'user_credentials' => array(

        ),
    ),

    /**
     * Servers
     *
     * OAuth 2 server list and configurations
     */
    'servers' => array(
        'default' => array(
            'storage' => array(

            ),
            'grant_types' => array(

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
