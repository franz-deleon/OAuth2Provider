<?php
namespace OAuth2Provider\Builder;

use OAuth2Provider\Containers\ContainerInterface;
use OAuth2Provider\Exception;

use Zend\ServiceManager\ServiceLocatorInterface;

class StrategyBuilder
{
    protected $serviceLocator;
    protected $strategyTypes = array();
    protected $serverKey;
    protected $strategies = array();
    protected $concreteClasses = array();
    protected $container;
    protected $interface;

    /**
     * We need all of the setters to construct
     *
     * @param array              $strategyTypes
     * @param string             $serverKey
     * @param array              $strategies
     * @param array              $concreteClasses
     * @param ContainerInterface $container
     * @param string             $interface
     */
	public function __construct(
	   array $strategyTypes,
	   $serverKey,
	   array $strategies,
	   array $concreteClasses,
	   ContainerInterface $container,
	   $interface
	) {
        $this->strategyTypes   = $strategyTypes;
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
        $strategyTypes   = $this->strategyTypes;
        $serverKey       = $this->serverKey;
        $strategies      = $this->strategies;
        $concreteClasses = $this->concreteClasses;
        $container       = $this->container;
        $interface       = $this->interface;

        foreach ($strategyTypes as $strategyName => $strategyParams) {
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
            } else {
                $featureName   = null;
                $featureParams = array();
            }

            if (isset($featureName)) {
                if ($serviceLocator->has($featureName)) {
                    $strategyParams = $serviceLocator->get($featureName);
                } else {
                    /** maps the strategy type to a strategy **/
                    // a strategy key is available
                    if (isset($strategies[$strategyName])) {
                        $strategyContainerKey = $strategyName;
                        $strategy = $strategies[$strategyContainerKey];
                        if (!isset($featureParams['storage'])) {
                            $featureParams['storage'] = $strategyContainerKey;
                        }
                    } else {
                        // if class is a direct implementation of grant type class
                        if (in_array($featureName, $concreteClasses)) {
                            $strategyContainerKey = array_search($featureName, $concreteClasses);
                            $strategy = $strategies[$strategyContainerKey];
                        } else {
                            // look at the parent as our last check
                            $parentClass = get_parent_class($featureName);
                            if (in_array($parentClass, $concreteClasses)) {
                                $strategyContainerKey = array_search($parentClass, $concreteClasses);
                                $strategy = $strategies[$strategyContainerKey];
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

                    // forward construction to grant type strategy
                    $strategy = $serviceLocator->get($strategy);
                    $strategyObj = $strategy($featureName, $featureParams, $serverKey);
                }
            }

            if (!is_subclass_of($strategyObj, $interface)) {
                throw new Exception\InvalidClassException(sprintf(
                    "Class '%s' error: '%s' is not of '%s'",
                    __METHOD__,
                    get_class($strategyObj),
                    $interface
                ));
            }

            // figure grant type key if not defined, usually used on a php object
            if (!isset($strategyContainerKey)) {
                $grantTypeClass = get_class($strategyObj);
                $strategyContainerKey = array_search($grantTypeClass, $concreteClasses);
                if (false === $strategyContainerKey) {
                    // try the parent class if it can be mapped
                    $parentClass = get_parent_class($strategyObj);
                    $strategyContainerKey = array_search($parentClass, $concreteClasses);

                    // if still no mapping, try to extract from the classname
                    if (false === $strategyContainerKey) {
                        $strategyContainerKey = $serviceLocator->get('FilterManager')
                            ->get('wordcamelcasetounderscore')
                            ->filter(Utilities::extractClassnameFromFQNS($grantTypeClass));

                        // because we have an underscored keys, try one last time to loop
                        // through each and find a map and return the first match
                        foreach (array_flip($concreteClasses) as $grantTypeId) {
                            if (false !== stripos($strategyContainerKey, $grantTypeId)) {
                                $strategyContainerKey = $grantTypeId;
                                break;
                            }
                        }
                    }
                }
            }

            // store the grant type in the container
            $container[$serverKey][$strategyContainerKey] = $strategyObj;
        }

        return $container->getServerContents($serverKey);
    }
}
