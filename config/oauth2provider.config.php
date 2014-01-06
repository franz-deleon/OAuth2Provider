<?php
return array(
    /**
     * The module works by defining how to create the OAuth 2 Server.
     * OAuth2Provider module will do its best to map grant types, response type, etc..
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
     * (Please look at module.config.php.dist for a template example)
     *
     * The available configuration keys provided for 'servers' are:
     *
     * a. storages
     * b. configs
     * c. server_class
     * d. version
     * e. controller
     * f. grant_types
     * g. response_types
     * h. token_type
     * i. scope_util
     * j. client_assertion_type
     *
     * You can view the list of configurations in: OAuth2Provider\Options\ServerConfigurations
     * You can also define multiple server keys for different configurations.
     */
    'servers' => array(
        // *********************************************************************************
        // This is for demonstration purposes only to show the servers usage variations.
        //                             DO NOT USE AS IS!!
        // *********************************************************************************

        // The assigned server key name. Each server is required an array key to initialize.
        //     - Configurations can be found in OAuth2Provider\Options\ServerConfigurations
        //     - The servers are initialized by OAuth2Provider\Service\AbstractFactory\ServerAbstractFactory
        //
        // Rename to 'default' if you want to set as the default server configuration
        // then you will be able to access it as:
        // <code>
        // $sm->get('oauth2provider.server.main');
        // </code>
        //
        // Otherwise, you can access the server by:
        // <code>
        // $sm->get('oauth2provider.server.my_custom_server_key');
        // </code>
        //
        'my_custom_server_key' => array(

             // a. Storages - A key where to define the OAuth2 storages to be implemented.
             //    - The 'storages' key is initialized by Service\Factory\ServerFeature\StorageFactory
             //    - Initialized storages are stored in container Container\StorageContainer
             //
             //    List of supported storages (please refer to OAuth2\Storage):
             //
             //    1. 'access_token'
             //    2. 'authorization_code'
             //    3. 'client_credentials'
             //    4. 'client'
             //    5. 'refresh_token'
             //    6. 'user_credentials'
             //    7. 'jwt_bearer'
             //    8. 'scope'
             //
            'storages' => array(
                // *********************************************************
                // ** Bellow are variances on how you can define a storage
                // *********************************************************

                // a. Initializing using a ServiceManager element.
                //    Example of how you can initialize a storage using a Servicemanager
                //    where hash has a combination of storage key 'access_token' and sm key 'SomeStorageServiceManagerFactory'
                'authorization_code' => 'SomeStorageServiceManagerFactory',
                // b. Initializing using a FQNS (Fully Qualified Namespace) string
                'user_credentials' => 'OAuth2ProviderTests\Assets\Storage\UserCredentialsStorage',
                // c. Initializing using a PHP object instance
                'access_token'  => new \OAuth2ProviderTests\Assets\Storage\AccessTokenStorage(),
                // d. Initializing using a closure.
                //    The closure will be injected with a ServiceManager instance by default
                'refresh_token' => function ($sm) {
                    return new \OAuth2ProviderTests\Assets\Storage\RefreshTokenStorage();
                }
            ),

            // b. Configs - A key for optional OAuth2 server configuration overrides.
            //    - The 'configs' key is initialized by Service\Factory\ServerFeature\ConfigFactory
            //    - Initialized configs are stored in container Container\ConfigContainer
            //
            //    The list below shows the available and default configuration settings:
            'configs' => array(
                'access_lifetime'            => 3600,
                'www_realm'                  => 'Service',
                'token_param_name'           => 'access_token',
                'token_bearer_header_name'   => 'Bearer',
                'enforce_state'              => true,
                'require_exact_redirect_uri' => true,
                'allow_implicit'             => false,
                'allow_credentials_in_request_body' => true,
            ),

            // c. Server Class - The concrete server class where the OAuth2 server is initialized.
            //    You can override this by providing an fqns classname.
            //
            //    Defaults to: OAuth2Provider\Server
            'server_class' => 'OAuth2Provider\Server',

            // d. Version - The server version tag
            //    Version should always start with a 'v'
            //    example: v1, v1.1, v1.1.2
            //
            //    You can access a version in routing for example by:
            //    http://[domain]/oauth2/v1/authorize
            //
            //    The above example access the server version 1 of the main server
            'version' => '',

            // e. Controller - The specific controller to use for this server
            //    Controller should be fqns
            'controller' => '',

            // ****************************************************************************************************************************
            // ** Optional config variations below are applied for configurations:
            // ** 'grant_types', 'response_types', 'token_type', 'scope_util', 'client_assertion_type'
            //
            // The config options are backed by a mapper class that supports configurations with different variations
            // or config formats for flexibility. As an example for the different variations that you will see below, a 'user_credentials'
            // key is used for demonstration on application of the 'grant_type' strategy.
            //
            // ****************************************************************************************************************************
            'grant_types' => array(
                // a. Using 'user_credentials' as hash key with a specific user storage
                'user_credentials' => array(
                    'options' => array(
                        'storage' => 'OAuth2ProviderTests\Assets\Storage\UserCredentialsStorage'
                    ),
                ),
                // b. Array variation where 'name' is used inside the configuration array
                array(
                    'name' => 'user_credentials',
                    'options' => array(
                        'storage' => 'OAuth2ProviderTests\Assets\Storage\UserCredentialsStorage',
                    ),
                ),
                // c. Using a concrete OAuth2 class assigned to 'name' key.
                array(
                    'name' => 'OAuth2\GrantType\UserCredentials',
                    //A specific storage can also be used by adding an options key:
                    'options' => array(
                         'storage' => 'OAuth2ProviderTests\Assets\Storage\UserCredentialsStorage'
                    ),
                ),
                // d. Using 'user_credentials' as key with a value of a concrete grant type class (must be fqns).
                'user_credentials' => 'OAuth2\GrantType\UserCredentials',
                // e. You can also use a Fully qualified name space that extends a concrete grant type class as its parent
                'OAuth2ProviderTests\Assets\GrantTypeWithParentUserCredentials',
                // f. Same as above but using a 'user_credentials' key for faster mapping
                'user_credentials' => 'OAuth2ProviderTests\Assets\GrantTypeWithParentUserCredentials',
                // g. An existing Service Manager element that may be defined in getServiceConfig() or module.config.php under 'services'
                'user_credentials' => 'AServiceManagerElementFactory',
                // h. For the lazy, You can just add, 'user_credentials' as an array value.
                //    The module will map/reuse the user_credentials storage that you defined in 'storages'
                //    and inject it to the default concrete class automatically.
                'user_credentials',
            ),
            // ************************************************************************************************************************
            // *** End of optional config variation example
            // ***
            // *** Again, the config variations above can be applied to the following strategies below
            // ************************************************************************************************************************

            // f. Grant Types - A key for Grant Type configurations
            //    - The 'grant_types' key is initialized by Service\Factory\ServerFeature\GrantTypeFactory
            //    - Initialized objects are stored in container Container\GrantTypeContainer.
            //    - The configuration objects can be found in OAuth2Provider\Options\GrantType\*
            //
            //    The list below shows the available grant types strategies and usages:
            //
            //    1. authorization_code
            //    2. client_credentials
            //    3. refresh_token
            //    4. user_credentials
            //
            'grant_types' => array(
                // 1. authorization_code strategy
                array(
                    'name' => 'authorization_code',
                    // list of available options:
                    'options' => array(
                        // *_storage are mapped automatically to the defined 'storages' config. Use only if using a unique storage.
                        'authorization_code_storage' => 'OAuth2ProviderTests\Assets\Storage\AuthorizationCodeStorage',
                    ),
                ),
                // 2. client_credentials strategy
                array(
                    'name' => 'client_credentials',
                    // list of available options:
                    'options' => array(
                        // *_storage are mapped automatically to the defined 'storages' config. Use only if using a unique storage.
                        'client_credentials_storage' => 'OAuth2ProviderTests\Assets\Storage\ClientCredentialsStorage',
                        // list of available configs:
                        'configs' => array(
                            'allow_credentials_in_request_body' => true
                        ),
                    ),
                ),
                // 3. refresh_token strategy
                array(
                    'name' => 'refresh_token',
                    // list of available options:
                    'options' => array(
                        // *_storage are mapped automatically to the defined 'storages' config. Use only if using a unique storage.
                        'refresh_token_storage' => 'OAuth2ProviderTests\Assets\Storage\RefreshTokenStorage',
                        // list of available configs:
                        'configs' => array(
                            'always_issue_new_refresh_token' => false
                        ),
                    ),
                ),
                // 4. user_credentials strategy
                array(
                    'name' => 'user_credentials',
                    // list of available options:
                    'options' => array(
                        // *_storage are mapped automatically to the defined 'storages' config. Use only if using a unique storage.
                        'user_credentials_storage' => 'OAuth2ProviderTests\Assets\Storage\UserCredentialsStorage',
                    ),
                ),
            ),

            // g. Response Types
            //    - The 'response_types' key is initialized by Service\Factory\ServerFeature\ResponseTypeFactory
            //    - Initialized objects are stored in container Container\ResponseTypeContainer.
            //    - The configuration objects can be found in OAuth2Provider\Options\ResponseType\*
            //
            //    The list below shows the available response types strategies and usages:
            //
            //    1. access_token
            //    2. authorization_code
            //
            'response_types' => array(
                // 1. access_token
                array(
                    'name' => 'access_token',
                    // list of available options:
                    'options' => array(
                        // *_storage are mapped automatically to the defined 'storages' config. Use only if using a unique storage.
                        'token_storage'   => 'OAuth2ProviderTests\Assets\Storage\AccessTokenStorage',
                        'refresh_storage' => 'OAuth2ProviderTests\Assets\Storage\RefreshTokenStorage',
                        // list of available configs:
                        'configs' => array(
                            'token_type'             => 'bearer',
                            'access_lifetime'        => 3600,
                            'refresh_token_lifetime' => 1209600,
                        ),
                    ),
                ),
                // 2. authorization_code
                array(
                    'name' => 'authorization_code',
                    // list of available options:
                    'options' => array(
                        // *_storage are mapped automatically to the defined 'storages' config. Use only if using a unique storage.
                        'authorization_code_storage' => 'OAuth2ProviderTests\Assets\Storage\AuthorizationCodeStorage',
                        // list of available configs:
                        'configs' => array(
                            'enforce_redirect'   => false,
                            'auth_code_lifetime' => 30,
                        ),
                    ),
                ),
            ),

            // h. Token Types
            //    - The 'token_type' key is initialized by Service\Factory\ServerFeature\TokenTypeFactory
            //    - Initialized objects are stored in container Container\TokenTypeContainer.
            //    - The configuration objects can be found in OAuth2Provider\Options\TokenType\*
            //
            //    The list below shows the available Token type(s) strategies and usages:
            //
            //    1. bearer
            //
            'token_type' => array(
                // 1. bearer
                'name' => 'bearer',
                // list of available options:
                'options' => array(
                    // list of available configs:
                    'configs' => array(
                        'token_param_name'         => 'access_token',
                        'token_bearer_header_name' => 'Bearer',
                    ),
                ),
            ),

            // i. Scope Util
            //    - The 'scope_util' key is initialized by Service\Factory\ServerFeature\ScopeTypeFactory
            //    - Initialized objects are stored in container Container\ScopeTypeContainer.
            //    - The configuration objects can be found in OAuth2Provider\Options\ScopeType\*
            //
            //    The list below shows the available Scope Util type(s) strategies and usages:
            //
            //    1. scope
            //
            'scope_util' => array(
                // 1. scope
                'name' => 'scope',
                // list of available options:
                'options' => array(
                    'use_defined_scope_storage' => true,
                    // Configrations below may be ignored if 'use_defined_score_storage' = true
                    // AND Scope Storage is already defined in 'storages' configuration
                    'default_scope' => 'scope1',
                    'supported_scopes' => 'scope1 scope2 scope3 scope4',
                    'client_supported_scopes' => array(
                        'myXclientXid' => 'scope1 scope2 scope3 scope4',
                    ),
                    'client_default_scopes' => array(
                        'myXclientXid' => 'scope1 scope2',
                    ),
                ),
            ),

            // j. Client Assertion Type
            //    - The 'client_assertion_type' key is initialized by Service\Factory\ServerFeature\ClientAssertionTypeFactory
            //    - Initialized objects are stored in container Container\ClientAssertionTypeContainer.
            //    - The configuration objects can be found in OAuth2Provider\Options\ClientAssertionType\*
            //
            //    The list below shows the available Client Assertion type(s) strategies and usages:
            //
            //    1. http_basic
            //
            'client_assertion_type' => array(
                // 1. http_basic
                'name' => 'http_basic',
                // list of available options:
                'options' => array(
                    // *_storage are mapped automatically to the defined 'storages' config. Use only if using a unique storage.
                    'client_credentials_storage' => 'OAuth2ProviderTests\Assets\Storage\ClientCredentialsStorage',
                    // list of available configs:
                    'configs' => array(
                        'allow_credentials_in_request_body' => true
                    ),
                ),
            ),
        ),
    ),

    /**
     * Main Primary Server
     *
     * Define by picking the "main server" to use from the server configurations list/keys above.
     * You can access the main server using the main service manager by:
     *
     * <code>
     * $sm->get('oauth2provider.server.main');
     * </code>
     *
     * Default: 'default'
     */
    'main_server' => '',

    /**
     * The main server version.
     * Useful if you have multiple server definitions like below:
     *
     * <code>
     * array(
     *     'servers' => array(
     *         'serverkey_1' => array(
     *             array('version' => 'v1'),
     *             array('version' => 'v2'),
     *         ),
     *     ),
     *     'main_server'  => 'serverkey_1',
     *     'main_version' => 'v2',
     * )
     * </code>
     *
     * Hence with the configuration above, a url endpoint with:
     * http://[domain]/oauth2/authorize
     * will automatically use 'serverkey_1' with version 2 ('v2')
     */
    'main_version' => '',

    /**
     * Default Controller to use if no controller is definded in server settings
     * Contains the routes to server endpoints.
     * Controller needs to be FQNS.
     */
    'default_controller' => 'OAuth2Provider\Controller\UserCredentialsController',
);
