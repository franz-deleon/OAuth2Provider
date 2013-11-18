<?php
return array(
    'routes' => array(
        'oauth2provider' => array(
            'type' => 'literal',
            'options' => array(
                'route' => '/oauth2',
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
                                    'action' => 'request',
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
                                'route' => '/resource',
                                'defaults' => array(
                                    'controller' => 'OAuthController',
                                    'action' => 'resource',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    )
);