<?php
return array(
    /**
     * List all server configurations
     */
    'server' => array(
        'default' => array(
            'storage' => array(
                ''
            ),
            'grant_types' => array(

            ),
        ),
       'custom_server' => array(
            'storage' => array(
                ''
            ),
            'grant_types' => array(

            ),
        ),
    ),

    /**
     * Define by picking the "main server" to use from above "server" configuration.
     * Default: default
     */
    'main_server' => 'custom_server',

    /**
     * Define which controller to use
     */
    'controller' => 'ApiOAuthProvider\Controller\UserCredentialsController',
);
