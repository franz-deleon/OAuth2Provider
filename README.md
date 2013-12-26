# OAuth 2 Provider Module for Zend Framework 2

OAuth2Provider module integrates Brent Shaffer's [OAuth2 Server](https://github.com/bshaffer/oauth2-server-php) with Zend Framework 2 easily.

## Installation

1. Easiest is through composer.
    ```sh
    php composer.phar require franz-deleon/fdl-oauth2-provider
    ```
    or in composer.json
    ```
    "require": {
        "franz-deleon/fdl-oauth2-provider": "dev-master"
    }
    ```
    then run `composer update`

2. Setup your configuration
    - Create 'oauth2provider' config key in your application's module.config.php
    - Copy the contents from OAuth2Provider/config/module.config.php.dist or rename this file to module.config.php if you dont have an existing module.config.php. If copying, make sure to copy only the data inside the 'oauth2provider' config key.
    - Fill up the configuration with your own settings. Refer to oauth2provider.config.php for documentation.
3. Define the main_server
    - Under the `oauth2provider` config key should be a `main_server` configuration.
    - Fill the `main_server` key with the custom server name you defined from step 2. The main_server will use the name `default` as the default name for a server key.

3. Enable the OAuth2Provider module in your `application.config.php`
    ```php
    return array(
        'modules' => array(
            'OAuth2Provider',
        ),
        [...]
    ```

## Configuration Options

You can also view the configuration documentation in `configs/oauth2provider.config.php`. Each configuration section has its own config options that can be viewed separately in `OAuth2Provider\Options\*`
```php
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
        // *********************************************************************************
        // This is for demonstration purposes only to show the server keys' usage variations.
        //                             DO NOT USE AS IS!!
        // *********************************************************************************

        // Assigned server key name for each server you want to initialize
        'my_custom_server_key' => array(
             // a. Storages - A key where to define the OAuth2 storages to be implemented.
             //    The 'storages' key is managed by Service\Factory\ServerFeature\StorageFactory
             //    and initialized storages are stored in container Container\StorageContainer.
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

            // b. Configs - A key for optional configuration overrides
            //    The 'configs' key is managed by Service\Factory\ServerFeature\ConfigFactory
            //    and initialized configs are stored in container Container\ConfigContainer.
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


            // ****************************************************************************************************************************
            // ** Config variations are applied for 'grant_types', 'response_types', 'token_type', 'scope_util', 'client_assertion_type' **
            //
            // The config options are backed by a mapper class that supports configurations with different variations
            // or config formats for flexibility. As an example for the different variations below, a 'user_credentials' key is used for
            // demonstration on application of the 'grant_type' strategy.
            //
            // Again, the variations example below also applies for any strategies under the following server keys:
            // 'grant_types', 'response_types', 'token_type', 'scope_util' and 'client_assertion_type'
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
            // *** End of VARIATIONS example
            // ************************************************************************************************************************

            // c. Grant Types - A key for Grant Type configurations
            //    The 'grant_types' key is managed by Service\Factory\ServerFeature\GrantTypeFactory
            //    and initialized objects are stored in container Container\GrantTypeContainer.
            //
            //    The list below shows the available grant types and usages:
            //
            //    1. authorization_code
            //    2. client_credentials
            //    3. refresh_token
            //    4. user_credentials
            'grant_types' => array(
                // 1. authorization_code strategy
                array(
                    'name' => 'authorization_code',
                    // list of available options:
                    'options' => array(
                        // *_storage are mapped automatically using the 'storages' config. Use only if using a unique storage
                        'authorization_code_storage' => 'OAuth2ProviderTests\Assets\Storage\AuthorizationCodeStorage',
                    ),
                ),
                // 2. client_credentials strategy
                array(
                    'name' => 'client_credentials',
                    // list of available options:
                    'options' => array(
                        // *_storage are mapped automatically using the 'storages' config. Use only if using a unique storage
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
                        // *_storage are mapped automatically using the 'storages' config. Use only if using a unique storage
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
                        // *_storage are mapped automatically using the 'storages' config. Use only if using a unique storage
                        'user_credentials_storage' => 'OAuth2ProviderTests\Assets\Storage\UserCredentialsStorage',
                    ),
                ),
            ),

            // d. Response Types
            //    The 'response_types' key is managed by Service\Factory\ServerFeature\ResponseTypeFactory
            //    and initialized objects are stored in container Container\ResponseTypeContainer.
            //
            //    The list below shows the available response types strategies and usages:
            //
            //    1. access_token
            //    2. authorization_code
            'response_types' => array(
                // 1. access_token
                array(
                    'name' => 'access_token',
                    // list of available options:
                    'options' => array(
                        // *_storage are mapped automatically using the 'storages' config. Use only if using a unique storage
                        'token_storage'   => 'OAuth2ProviderTests\Assets\Storage\AccessTokenStorage',
                        'refresh_storage' => 'OAuth2ProviderTests\Assets\Storage\RefreshTokenStorage',
                        // list of available configs:
                        'config' => array(
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
                        // *_storage are mapped automatically using the 'storages' config. Use only if using a unique storage
                        'authorization_code_storage' => 'OAuth2ProviderTests\Assets\Storage\AuthorizationCodeStorage',
                        'config' => array(
                            'enforce_redirect'   => false,
                            'auth_code_lifetime' => 30,
                        ),
                    ),
                ),
            ),

            // e. Token Types
            //    The 'token_type' key is managed by Service\Factory\ServerFeature\TokenTypeFactory
            //    and initialized objects are stored in container Container\TokenTypeContainer.
            //
            //    The list below shows the available Token type(s) strategies and usages:
            //
            //    1. bearer
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

            // f. Scope Util
            //    The 'scope_util' key is managed by Service\Factory\ServerFeature\ScopeTypeFactory
            //    and initialized objects are stored in container Container\ScopeTypeContainer.
            //
            //    The list below shows the available Scope Util type(s) strategies and usages:
            //
            //    1. scope
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

            // g. Client Assertion Type
            //    The 'client_assertion_type' key is managed by Service\Factory\ServerFeature\ClientAssertionTypeFactory
            //    and initialized objects are stored in container Container\ClientAssertionTypeContainer.
            //
            //    The list below shows the available Client Assertion type(s) strategies and usages:
            //
            //    1. http_basic
            'client_assertion_type' => array(
                // 1. http_basic
                'name' => 'http_basic',
                // list of available options:
                'options' => array(
                    // *_storage are mapped automatically using the 'storages' config. Use only if using a unique storage
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
     * Controller
     *
     * Define which controller to use:
     */
    'controller' => 'OAuth2Provider\Controller\UserCredentialsController',
);
```

### Usage

- You can access the server through the main Service Manager by:  
    `$sm->get('oauth2provider.server.main');`  
    or if you have a specific server key will be:  
    `$sm->get('oauth2provider.server.CustomServer');`
- You can also access each configuration (for example: 'grant_type') object by:  
    `$sm->get('oauth2provider.server.main.grant_type.user_credentials');`
- Access the server's Request object by:  
    `$sm->get('oauth2provider.server.main.request');`
- Access the server's Response object by:  
    `$sm->get('oauth2provider.server.main.response');`

### Routing

- The url below will automatically be created:
    - Request end point: `http://[domain]/oauth2/v1/request`
    - Resource end point: `http://[domain]/oauth2/v1/resource`
    - Authorize end point: `http://[domain]/oauth2/v1/authorize`
- Currently only a 2 legged with grant_type 'user_credentials' controller is available but you can apply your own controller by implementing interface `OAuth2Provider\Controller\ControllerInterface` and defining the controler in:

    ```php
    <?php
    array(
        'oauth2provider' => array(
            'controller' => 'ApiOauth2Server\Controller\SomeCustomController'
        )
    )
    ```
    * the endpoints above will still be valid
