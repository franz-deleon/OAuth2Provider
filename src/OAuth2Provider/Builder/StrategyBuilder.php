<?php
namespace OAuth2Provider\Builder;

use OAuth2Provider\Containers\ContainerInterface;
use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager\ServiceLocatorInterface;

class StrategyBuilder
{
    protected $subjects = array();
    protected $serverKey;
    protected $strategies = array();
    protected $concreteClasses = array();
    protected $container;
    protected $interface;

    /**
     * We need all of the setters to construct
     *
     * @param array              $subject
     * @param string             $serverKey
     * @param array              $strategies
     * @param array              $concreteClasses
     * @param ContainerInterface $container
     * @param string             $interface
     */
    public function __construct(
        array $subjects,
        $serverKey,
        array $strategies,
        array $concreteClasses,
        ContainerInterface $container,
        $interface
    ) {
        $this->subjects        = $subjects;
        $this->serverKey       = $serverKey;
        $this->strategies      = $strategies;
        $this->concreteClasses = $concreteClasses;
        $this->container       = $container;
        $this->interface       = $interface;
    }

    /**
     * Builds the strategy feature object
     * @param ServiceLocatorInterface $serviceLocator
     * @throws Exception\InvalidServerException
     * @throws Exception\InvalidClassException
     */
    public function initStrategyFeature(ServiceLocatorInterface $serviceLocator)
    {
        foreach ($this->subjects as $strategyName => $strategyParams) {
            if (is_array($strategyParams)) {
                $featureConfig = $serviceLocator->get('OAuth2Provider/Options/ServerFeatureType')->setFromArray($strategyParams);
                if (!$featureConfig->getName()) {
                    throw new Exception\InvalidServerException(sprintf(
                        "Class '%s' error: cannot find 'class' key in array",
                        __METHOD__
                    ));
                }
                $featureName   = $featureConfig->getName();
                $featureParams = $featureConfig->getParams();
            } elseif (is_string($strategyParams)) {
                $featureName   = $strategyParams;
                $featureParams = array();
            } elseif (is_object($strategyParams)) {
                $strategyObj = $strategyParams;
            } else {
                $featureName   = null;
                $featureParams = array();
            }

            if (isset($featureName)) {
                if ($serviceLocator->has($featureName)) {
                    $strategyObj = $serviceLocator->get($featureName);
                } else {
                    /** maps the strategy type to a strategy **/
                    // a strategy key is available
                    if (isset($this->strategies[$strategyName])) {
                        $strategyContainerKey = $strategyName;
                        $strategy = $this->strategies[$strategyContainerKey];
                        if (!isset($featureParams['storage'])) {
                            $featureParams['storage'] = $strategyContainerKey;
                        }
                    } else {
                        // if class is a direct implementation of grant type class
                        if (in_array($featureName, $this->concreteClasses)) {
                            $strategyContainerKey = array_search($featureName, $this->concreteClasses);
                            $strategy = $this->strategies[$strategyContainerKey];
                        } else {
                            // look at the parent as our last check
                            $parentClass = get_parent_class($featureName);
                            if (in_array($parentClass, $this->concreteClasses)) {
                                $strategyContainerKey = array_search($parentClass, $this->concreteClasses);
                                $strategy = $this->strategies[$strategyContainerKey];
                            }
                        }
                    }

                    if (!isset($strategy)) {
                        throw new Exception\InvalidClassException(sprintf(
                            "Class '%s' error: cannot map class '%s' to a strategy",
                            __METHOD__,
                            $featureName
                        ));
                    }

                    // forward construction specific strategy
                    $strategy = $serviceLocator->get($strategy);
                    $strategyObj = $strategy($featureName, $featureParams, $this->serverKey);
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

            // store the grant type in the container
            $this->container[$this->serverKey][$strategyContainerKey] = $strategyObj;
        }

        return $this->container->getServerContents($this->serverKey);
    }
}
