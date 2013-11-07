<?php
return array(
    'routes' => array(
        'apioauthprovider' => array(
            'type' => 'literal',
            'options' => array(
                'route' => '/oauth',
                'constraints' => array(),
                'defaults' => array(
                    'controller' => 'OAuthController',
                    'action' => 'index',
                ),
            ),
            'child_routes' => array(
                'v1' => array(
                    'type' => 'literal',
                    'options' => array(
                        'route' => '/v1',
                    ),
                    'child_routes' => array(
                        'request_token' => array(
                            'type' => 'Literal',
                            'options' => array(
                                'route' => '/request',
                                'defaults' => array(
                                    'controller' => 'OAuthController',
                                    'action' => 'request-token',
                                ),
                            ),
                        ),
                        'authorize' => array(
                            'type' => 'Literal',
                            'options' => array(
                                'route' => '/authorize',
                                'defaults' => array(
                                    'controller' => 'OAuthController',
                                    'action' => 'authorize',
                                ),
                            ),
                        ),
                        'access_token' => array(
                            'type' => 'Literal',
                            'options' => array(
                                'route' => '/access',
                                'defaults' => array(
                                    'controller' => 'OAuthController',
                                    'action' => 'access-token',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    )
);