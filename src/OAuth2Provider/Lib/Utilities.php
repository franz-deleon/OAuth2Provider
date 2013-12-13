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
     * 1. Checks if a server index exists in the storage
     * 2. Checks if given identifier exists in storage
     * 3. Checks if server index
     *
     * @param string                  $serverIndex     Server index
     * @param mixed                   $contentIndex    Content index
     * @param ContainerInterface      $container       Container to check against
     * @param ServiceLocatorInterface $serviceLocator  Service manager
     * @param string                  $identifier      Strategy identifier
     * @param string                  $defaultReturn   Default value to return. Defaults to null
     * @return object|null
     */
    public static function storageLookup(
        $serverIndex,
        $contentIndex,
        ContainerInterface $container,
        ServiceLocatorInterface $serviceLocator,
        $identifier = '',
        $defaultReturn = null
    ) {
        if (isset($container)
            && $container->isExistingServerContentInKey($serverIndex, $contentIndex)
        ) {
            return $container->getServerContentsFromKey($serverIndex, $contentIndex);
        } elseif (isset($container)
            && $container->isExistingServerContentInKey($serverIndex, $identifier)
        ) {
            return $container->getServerContentsFromKey($serverIndex, $identifier);
        } elseif (is_string($contentIndex) && isset($serviceLocator)
            && $serviceLocator->has($contentIndex)
        ) {
            return $serviceLocator->get($contentIndex);
        } elseif (is_object($contentIndex)) {
            return $contentIndex;
        }

        return $defaultReturn;
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

    /**
     * This a quick hack for the sm to check if sm key has been initialized yet
     *
     * @param ServiceLocatorInterface $sm
     * @param string $name
     * @return boolean
     */
    public static function hasSMInstance(ServiceLocatorInterface $sm, $name)
    {
        $replacements = array('-' => '', '_' => '', ' ' => '', '\\' => '', '/' => '');

        $instances = $sm->getRegisteredServices();
        $instances = $instances['instances'];

        $name = strtolower(strtr($name, $replacements));

        return in_array($name, $instances);
    }
}
