<?php
namespace OAuth2Provider\Lib;

use OAuth2Provider\Exception;
use OAuth2Provider\Containers\ContainerInterface;

use Zend\ServiceManager\ServiceLocatorInterface;

class Utilities
{
    /**
     * Common execution process to create an object out of <$class>
     *
     * 1. Checks if $class is a ServiceManager element
     * 2. If above did not pass, check if <$class> is valid FQNS
     * 3. If above did not pass, check if <$class> is callable
     * 4. If above did not pass, check if <$class> is object
     * 5. Returns an error if none of the above is valid
     *
     * @param mixed  $class           Target to execute in the flow
     * @param string $serviceManager  Service Manager
     * @param string $errorMessage    Error Message to produce
     * @throws Exception\ClassNotExistException
     * @return object
     */
    public static function createClass($class, ServiceLocatorInterface $serviceManager = null, $errorMessage = null)
    {
        if (isset($serviceManager)
            && (is_array($class) || is_string($class))
            && $serviceManager->has($class)
        ) {
            return $serviceManager->get($class);
        } elseif (is_string($class) && class_exists($class)) {
            return new $class();
        } elseif (is_callable($class)) {
            return call_user_func($class, $serviceManager);
        } elseif (is_object($class)) {
            return $class;
        } else {
            $errorMessage = $errorMessage ?: "Class {$class} cannot be created";
            throw new Exception\ClassNotExistException($errorMessage);
        }
    }

    /**
     * Extract the class name from a fully qualified namespace
     * @param string|object $class
     * @return mixed
     */
    public static function extractClassnameFromFQNS($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        if (is_string($class)) {
            $class = substr($class, (strrpos($class, '\\') + 1));
        }

        return $class;
    }

    /**
     * Checks for a given subject if it is stored in a given storage container
     *
     * @param mixed  $serverIndex
     * @param string $server
     * @param ContainerInterface $container
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $identifier
     * @param string $defaultReturn
     * @return object|null
     */
    public static function storageLookup(
        $server = null,
        $serverIndex = null,
        ContainerInterface $container = null,
        ServiceLocatorInterface $serviceLocator = null,
        $identifier = null,
        $defaultReturn = null
    ) {
        $result = null;

        // check if serverIndex is in the container
        if (isset($container)
            && $container->isExistingServerContentInKey($server, $serverIndex)
        ) {
            $result = $container->getServerContentsFromKey($server, $serverIndex);

        // check if identifier is present in the storage
        } elseif (isset($container)
            && $container->isExistingServerContentInKey($server, $identifier)
        ) {
            $result = $container->getServerContentsFromKey($server, $identifier);

        // check if the serverIndex is a service manager element
        } elseif (is_string($serverIndex) && isset($serviceLocator)
            && $serviceLocator->has($serverIndex)
        ) {
            $result = $serviceLocator->get($serverIndex);

        // check if the subject is an object
        } elseif (is_object($serverIndex)) {
            $result = $serverIndex;
        } else {
            $result = $defaultReturn;
        }

        return $result;
    }

    /**
     * This function makes sure the array being
     * passed is of one strategy object only
     *
     * @param mixed $strategy
     * @return array
     */
    public static function singleStrategyOptionExtractor($strategy)
    {
        if (!is_array($strategy)) {
            $strategy = array($strategy);
        }
        if (count($strategy) > 1) {
            $shift = true;
            foreach ($strategy as $element) {
                if (!is_array($element)) {
                    $shift = false;
                    break;
                }
            }
            if (true === $shift) {
                $strategy = array_shift($strategy);
            }
            $strategy = array($strategy);
        }

        return $strategy;
    }
}
