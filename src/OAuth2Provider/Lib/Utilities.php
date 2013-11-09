<?php
namespace OAuth2Provider\Lib;

use OAuth2Provider\Exception;

use Zend\ServiceManager\ServiceLocatorInterface;

class Utilities
{
    /**
     * Common execution process to create an object out of <$class>
     *
     * 1. Checks if $class is a ServiceManager element
     * 2. If above not pass, check if <$class> is valid FQNS
     * 4. If above not pass, check if <$class> is callable
     * 5. If above not pass, check if <$class> is object
     * 6. Returns an error none of above is valid
     *
     * @param mixed  $class           Target to execute in the flow
     * @param string $serviceManager  Service Manager
     * @param string $errorMessage    Error Message to produce
     * @throws Exception\ClassNotExistException
     * @return object
     */
    public static function createClass($class, ServiceLocatorInterface $serviceManager = null, $errorMessage = null)
    {
        if (null !== $serviceManager &&
            (is_array($class) || is_string($class))
            && $serviceManager->has($class)
        ) {
            return $serviceManager->get($class);
        } elseif (is_string($class) && class_exists($class)) {
            return new $class();
        } elseif (is_callable($class)) {
            return call_user_func($class);
        } elseif (is_object($class)) {
            return $class;
        } else {
            $errorMessage = $errorMessage ?: "Class {$class} cannot be created";
            throw new Exception\ClassNotExistException($errorMessage);
        }
    }
}
