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
                'version' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route' => '[/:version]',
                        'constraints' => array(
                            'version' => 'v[a-zA-Z0-9._-]+',
                        ),
                        'defaults' => array(
                            'version' => null
                        ),
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