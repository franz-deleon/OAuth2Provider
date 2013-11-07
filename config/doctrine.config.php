<?php
return array(
    'driver' => array(
        // defines an annotation driver with two paths, and names it `my_annotation_driver`
        'annotation_driver' => array(
            'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
            'cache' => 'array',
            'paths' => array(
                realpath(__DIR__ . '/../src/ApiOAuthProvider/Model/Entity'),
            ),
        ),
        'yaml_driver' => array(
            'class' => 'Doctrine\ORM\Mapping\Driver\YamlDriver',
            'paths' => array(
                realpath(__DIR__ . '/../src/ApiOAuthProvider/Model/Yaml'),
            ),
        ),

        // default metadata driver, aggregates all other drivers into a single one.
        // Override `orm_default` only if you know what you're doing
        'orm_default' => array(
            'drivers' => array(
                // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                'ApiOAuthProvider\Model\Entity' => 'annotation_driver',
                //'ApiOAuthProvider\Yaml' => 'yaml_driver',
            )
        )
    )
);