<?php
namespace OAuth2Provider\Builder;

use OAuth2Provider\Containers\ContainerInterface;
use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager\ServiceLocatorInterface;

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
    public function initStrategyFeature(ServiceLocatorInterface $serviceLocator)
    {
        $strategies = !is_array($this->strategies) && !empty($this->strategies)
            ? array($this->strategies)
            : (!empty($this->strategies) ? $this->strategies : array());

        foreach ($strategies as $strategyName => $strategyOptions) {
            if (is_array($strategyOptions)) {
                $featureConfig = $serviceLocator->get('OAuth2Provider/Options/ServerFeatureType')->setFromArray($strategyOptions);
                if (!$featureConfig->getName()) {
                    throw new Exception\InvalidServerException(sprintf(
                        "Class '%s' error: cannot find 'class' key in array",
                        __METHOD__
                    ));
                }
                $featureName   = $featureConfig->getName();
                $featureOptions = $featureConfig->getOptions();
            } elseif (is_string($strategyOptions)) {
                $featureName   = $strategyOptions;
                $featureOptions = array();
            } elseif (is_object($strategyOptions)) {
                $strategyObj = $strategyOptions;
            }

            if (isset($featureName)) {
                if ($serviceLocator->has($featureName)) {
                    $strategyObj = $serviceLocator->get($featureName);
                } else {
                    /** Attempt to map a strategy to one of the available strategies **/

                    /** checke if a strategy key is available **/
                    if (isset($this->availableStrategies[$strategyName])) {
                        $strategyContainerKey = $strategyName;
                        $strategy = $this->availableStrategies[$strategyContainerKey];
                        if (!isset($featureOptions['storage'])) {
                            $featureOptions['storage'] = $strategyContainerKey;
                        }

                    /** check if feature name is a key of available strategies **/
                    } elseif (isset($this->availableStrategies[$featureName])) {
                        $strategyContainerKey = $featureName;
                        $strategy    = $this->availableStrategies[$featureName];
                        $featureName = $this->concreteClasses[$featureName];

                     /** check if name is a direct implementation of a concrete class **/
                    } elseif (in_array($featureName, $this->concreteClasses)) {
                         $strategyContainerKey = array_search($featureName, $this->concreteClasses);
                         $strategy = $this->availableStrategies[$strategyContainerKey];

                    /** look at the parent as our last check **/
                    } else {
                        $parentClass = get_parent_class($featureName);
                        if (in_array($parentClass, $this->concreteClasses)) {
                            $strategyContainerKey = array_search($parentClass, $this->concreteClasses);
                            $strategy = $this->availableStrategies[$strategyContainerKey];
                        }
                    }

                    if (!isset($strategy)) {
                        throw new Exception\InvalidClassException(sprintf(
                            "Class '%s' error: cannot map class '%s' to a strategy",
                            __METHOD__,
                            $featureName
                        ));
                    }

                    // forward construction to specific strategy
                    $strategy = $serviceLocator->get($strategy);
                    $strategyObj = $strategy($featureName, $featureOptions, $this->serverKey);

                    // unset common vars
                    unset($strategy, $featureName, $featureOptions);
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
                $grantTypeClass = get_class($strategyObj);
                $strategyContainerKey = array_search($grantTypeClass, $this->concreteClasses);
                if (false === $strategyContainerKey) {
                    // try the parent class if it can be mapped
                    $parentClass = get_parent_class($strategyObj);
                    $strategyContainerKey = array_search($parentClass, $this->concreteClasses);

                    // if still no mapping, try to extract from the classname
                    if (false === $strategyContainerKey) {
                        $strategyContainerKey = $serviceLocator->get('FilterManager')
                            ->get('wordcamelcasetounderscore')
                            ->filter(Utilities::extractClassnameFromFQNS($grantTypeClass));

                        // because we have an underscored keys, try one last time to loop
                        // through each and find a map and return the first match
                        foreach (array_flip($this->concreteClasses) as $grantTypeId) {
                            if (false !== stripos($strategyContainerKey, $grantTypeId)) {
                                $strategyContainerKey = $grantTypeId;
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
