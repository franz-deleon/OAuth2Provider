<?php
namespace OAuth2Provider\Lib;

use OAuth2Provider\AbstractServiceLocatorAware;

class StrategyTypeContainerInjector extends AbstractServiceLocatorAware
{
    protected $strategyTypes = array();
    protected $serverKey;
    protected $strategies = array();
    protected $concreteClasses = array();
    protected $container;

    /**
     * We need all of the setters to construct
     * @param unknown $strategyTypes
     * @param unknown $serverKey
     * @param unknown $strategies
     * @param unknown $concreteClasses
     * @param unknown $container
     */
	public function __construct($strategyTypes, $serverKey, $strategies, $concreteClasses, $container)
    {
        $this->setStrategyTypes($strategyTypes)
            ->setServerKey($serverKey)
            ->setStrategies($strategies)
            ->setConcreteClasses($concreteClasses)
            ->setContainer($container);
    }

    public function createContainer()
    {
        $strategyTypes = $this->getStrategyTypes();
        $serverKey = $this->getServerKey();
        $strategies = $this->getStrategies();
        $concreteClasses = $this->getConcreteClasses();
        $container = $this->getContainer();


        $grantTypeContainer = $serviceLocator->get('OAuth2Provider/Containers/GrantTypeContainer');


        foreach ($grantTypes as $grantTypeName => $grantType) {
            if (is_array($grantType)) {
                if (!isset($grantType['class'])) {
                    throw new Exception\InvalidServerException(sprintf(
                        "Class '%s' error: cannot find 'class' key in array",
                        __METHOD__
                    ));
                }
                $class  = $grantType['class'];
                $params = isset($grantType['params']) ? $grantType['params'] : null;
            } elseif (is_string($grantType)) {
                $class  = $grantType;
                $params = null;
            } else {
                $class  = null;
                $params = null;
            }

            if (isset($class)) {
                if ($serviceLocator->has($class)) {
                    $grantType = $serviceLocator->get($class);
                } else {
                    /** maps the grant type to a strategy **/
                    // a strategy key is available
                    if (isset($strategies[$grantTypeName])) {
                        $grantTypeKey = $grantTypeName;
                        $strategy     = $strategies[$grantTypeKey];
                        if (!isset($params['storage'])) {
                            $params['storage'] = $grantTypeKey;
                        }
                    } else {
                        if (empty($params)) {
                            throw new Exception\InvalidConfigException(sprintf(
                                "Class '%s' error: 'params' configuration is missing",
                                __METHOD__
                            ));
                        }

                        // if class is a direct implementation of grant type class
                        if (in_array($class, $concreteClasses)) {
                            $grantTypeKey = array_search($class, $concreteClasses);
                            $strategy = $strategies[$grantTypeKey];
                        } else {
                            // look at the parent as our last check
                            $parentClass = get_parent_class($class);
                            if (in_array($parentClass, $concreteClasses)) {
                                $grantTypeKey = array_search($parentClass, $concreteClasses);
                                $strategy = $strategies[$grantTypeKey];
                            }
                        }
                    }

                    if (!isset($strategy)) {
                        throw new Exception\InvalidClassException(sprintf(
                            "Class '%s' error: cannot map class '%s' to a Grant Type strategy",
                            __METHOD__,
                            $class
                        ));
                    }

                    // forward construction to grant type strategy
                    $grantTypeStrategy = $serviceLocator->get($strategy);
                    $grantType = $grantTypeStrategy($class, $params, $serverKey);
                }
            }

            if (!$grantType instanceof GrantTypeInterface) {
                throw new Exception\InvalidClassException(sprintf(
                    "Class '%s' error: '%s' is not of GrantTypeInterface",
                    __METHOD__,
                    get_class($grantType)
                ));
            }

            // figure grant type key if not defined, usually used on a php object
            if (!isset($grantTypeKey)) {
                $grantTypeClass = get_class($grantType);
                $grantTypeKey = array_search($grantTypeClass, $concreteClasses);
                if (false === $grantTypeKey) {
                    // try the parent class if it can be mapped
                    $parentClass = get_parent_class($grantType);
                    $grantTypeKey = array_search($parentClass, $concreteClasses);

                    // if still no mapping, try to extract from the classname
                    if (false === $grantTypeKey) {
                        $grantTypeKey = $serviceLocator->get('FilterManager')
                            ->get('wordcamelcasetounderscore')
                            ->filter(Utilities::extractClassnameFromFQNS($grantTypeClass));

                        // because we have an underscored keys, try one last time to loop
                        // through each and find a map and return the first match
                        foreach (array_flip($concreteClasses) as $grantTypeId) {
                            if (false !== stripos($grantTypeKey, $grantTypeId)) {
                                $grantTypeKey = $grantTypeId;
                                break;
                            }
                        }
                    }
                }
            }

            // store the grant type in the container
            $grantTypeContainer[$serverKey][$grantTypeKey] = $grantType;
        }

        return $grantTypeContainer->getServerContents($serverKey);
    }

    /**
     * @return the $strategyTypes
     */
    public function getStrategyTypes()
    {
        return $this->strategyTypes;
    }

	/**
     * @param multitype: $strategyTypes
     */
    public function setStrategyTypes($strategyTypes)
    {
        $this->strategyTypes = $strategyTypes;
        return $this;
    }

	/**
     * @return the $serverKey
     */
    public function getServerKey()
    {
        return $this->serverKey;
    }

	/**
     * @param field_type $serverKey
     */
    public function setServerKey($serverKey)
    {
        $this->serverKey = $serverKey;
        return $this;
    }

	/**
     * @return the $strategies
     */
    public function getStrategies()
    {
        return $this->strategies;
    }

	/**
     * @param multitype: $strategies
     */
    public function setStrategies($strategies)
    {
        $this->strategies = $strategies;
        return $this;
    }

	/**
     * @return the $concreteClasses
     */
    public function getConcreteClasses()
    {
        return $this->concreteClasses;
    }

	/**
     * @param multitype: $concreteClasses
     */
    public function setConcreteClasses($concreteClasses)
    {
        $this->concreteClasses = $concreteClasses;
        return $this;
    }

    /**
     * @return the $container
     */
    public function getContainer()
    {
        return $this->container;
    }

	/**
     * @param field_type $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }
}
