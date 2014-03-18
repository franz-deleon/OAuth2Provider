<?php
namespace OAuth2Provider\Builder;

use OAuth2Provider\Containers\ContainerInterface;
use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager;

class StrategyBuilder
{
    protected $strategies = array();
    protected $serverKey;
    protected $availableStrategies = array();
    protected $concreteClasses = array();
    protected $container;
    protected $interface;

    /**
     * We need all of the properties to construct
     *
     * @param array              $strategies           List of strategies to map
     * @param string             $serverKey            The server key where the strategy is stored
     *                                                 in the container
     * @param array              $availableStrategies  List of available strategies this moduls supports
     * @param array              $concreteClasses      Concrete classes mapping to strategy keys
     * @param ContainerInterface $container            The container to look for
     * @param string             $interface            The interface to check against
     *                                                 the initialized strategy
     */
    public function __construct(
        $strategies,
        $serverKey,
        array $availableStrategies,
        array $concreteClasses,
        ContainerInterface $container,
        $interface
    ) {
        $this->strategies          = $strategies;
        $this->serverKey           = $serverKey;
        $this->availableStrategies = $availableStrategies;
        $this->concreteClasses     = $concreteClasses;
        $this->container           = $container;
        $this->interface           = $interface;
    }

    /**
     * Builds the strategy feature object
     * @param ServiceLocatorInterface $serviceLocator
     * @throws Exception\InvalidServerException
     * @throws Exception\InvalidClassException
     */
    public function initStrategyFeature(ServiceManager\ServiceManager $serviceLocator)
    {
        $strategies = !is_array($this->strategies) && !empty($this->strategies)
            ? array($this->strategies)
            : (!empty($this->strategies) ? $this->strategies : array());

        foreach ($strategies as $strategyKey => $strategyVal) {
            if (is_array($strategyVal)) {
                $options = $serviceLocator
                    ->get('OAuth2Provider/Options/ServerFeatureType')
                    ->setFromArray($strategyVal);

                switch (true) {
                    case $options->getName():
                        $strategyName = $options->getName();
                        break;
                    case is_string($strategyKey):
                        $strategyName = $strategyKey;
                        break;
                    case ($strategyVal = array_shift($strategyVal)) && is_string($strategyVal):
                        $strategyName = $strategyVal;
                        break;
                    default:
                        $strategyName = null;
                }
                $strategyOptions = $options->getOptions() ?: array();

                if (!$strategyName) {
                    throw new Exception\InvalidServerException(sprintf(
                        "Class '%s' error: cannot figure strategy key",
                        __METHOD__
                    ));
                }
            } elseif (is_string($strategyVal)) {
                $strategyName = $strategyVal;
                $strategyOptions = array();
            } elseif (is_object($strategyVal)) {
                $strategyObj = $strategyVal;
            }

            if (isset($strategyName)) {
                if ($serviceLocator->has($strategyName)) {
                    $strategyObj = $serviceLocator->get($strategyName);
                } else {
                    /** Attempt to map a strategy to one of the available strategies **/

                    /** check if a strategy key is defined and available **/
                    if (isset($this->availableStrategies[$strategyKey])) {
                        $strategyContainerKey = $strategyKey;
                        $strategy     = $this->availableStrategies[$strategyContainerKey];
                        $strategyName = (is_string($strategyName) && class_exists($strategyName))
                            ? $strategyName
                            : $this->concreteClasses[$strategyContainerKey];
                        if (!isset($strategyOptions['storage'])) {
                            $strategyOptions['storage'] = $strategyContainerKey;
                        }

                    /** check if feature name is a key of available strategies **/
                    } elseif (isset($this->availableStrategies[$strategyName])) {
                        $strategyContainerKey = $strategyName;
                        $strategy     = $this->availableStrategies[$strategyName];
                        $strategyName = $this->concreteClasses[$strategyName];

                     /** check if name is a direct implementation of a concrete class **/
                    } elseif (in_array($strategyName, $this->concreteClasses)) {
                         $strategyContainerKey = array_search($strategyName, $this->concreteClasses);
                         $strategy     = $this->availableStrategies[$strategyContainerKey];
                         $strategyName = $this->concreteClasses[$strategyContainerKey];

                    /** look at the parent as our last check **/
                    } else {
                        $parentClasses = class_exists($strategyName) ? class_parents($strategyName) : null;
                        if (!empty($parentClasses)) {
                            foreach ($parentClasses as $parentClass) {
                                if (in_array($parentClass, $this->concreteClasses)) {
                                    $strategyContainerKey = array_search($parentClass, $this->concreteClasses);
                                    $strategy     = $this->availableStrategies[$strategyContainerKey];
                                    $strategyName = $strategyName ?: $this->concreteClasses[$strategyContainerKey];
                                    break;
                                }
                            }
                        }
                    }

                    if (!isset($strategy)) {
                        throw new Exception\InvalidClassException(sprintf(
                            "Class '%s' error: cannot map class '%s' to a strategy",
                            __METHOD__,
                            $strategyName
                        ));
                    }

                    // forward construction to specific strategy
                    $strategy = $serviceLocator->get($strategy);
                    $strategyObj = $strategy($strategyName, $strategyOptions, $this->serverKey);

                    // as a convenience for closure inject the sm if its of a service aware interface
                    if ($strategyObj instanceof ServiceManager\ServiceLocatorAwareInterface) {
                        $strategyObj->setServiceLocator($serviceLocator);
                    } elseif ($strategyObj instanceof ServiceManager\ServiceManagerAwareInterface) {
                        $strategyObj->setServiceManager($serviceLocator);
                    }

                    // unset common vars
                    unset($strategy, $strategyName, $strategyOptions);
                }
            }

            if (!is_subclass_of($strategyObj, $this->interface)) {
                throw new Exception\InvalidClassException(sprintf(
                    "Class '%s' error: '%s' is not of '%s'",
                    __METHOD__,
                    get_class($strategyObj),
                    $this->interface
                ));
            }

            // figure container server key if not defined, usually will occur on a php obj
            if (!isset($strategyContainerKey)) {
                $objClassname = get_class($strategyObj);
                $strategyContainerKey = array_search($objClassname, $this->concreteClasses);
                if (false === $strategyContainerKey) {
                    // try the parent class if it can be mapped
                    $parentClasses = class_exists($objClassname) ? class_parents($strategyObj) : null;
                    if (!empty($parentClasses)) {
                        foreach ($parentClasses as $parentClass) {
                            $strategyContainerKey = array_search($parentClass, $this->concreteClasses);
                            if (false !== $strategyContainerKey) {
                                break;
                            }
                        }
                    }

                    // if still no mapping, try to extract from the classname
                    // note: we need a key in any case even if nothing matches
                    if (false === $strategyContainerKey) {
                        $strategyContainerKey = $serviceLocator->get('FilterManager')
                            ->get('wordcamelcasetounderscore')
                            ->filter(Utilities::extractClassnameFromFQNS($objClassname));

                        // because we have an underscored keys, try one last time to loop
                        // through each and find a map and return the first match
                        // example: 'Grant_Type_Custom_User_Credentials' will match 'user_credentials'
                        foreach (array_keys($this->concreteClasses) as $strategyId) {
                            if (false !== stripos($strategyContainerKey, $strategyId)) {
                                $strategyContainerKey = $strategyId;
                                break;
                            }
                        }
                    }
                }
            }

            // store the object in the container
            $this->container[$this->serverKey][$strategyContainerKey] = $strategyObj;
            unset($strategyObj, $strategyContainerKey);
        }

        return $this->container->getServerContents($this->serverKey);
    }
}
