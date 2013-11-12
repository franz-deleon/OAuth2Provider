<?php
namespace OAuth2Provider\Service\Factory\ServerFeature;

use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use OAuth2\ResponseType\ResponseTypeInterface;

use Zend\ServiceManager;

class ResponseTypeFactory implements ServiceManager\FactoryInterface
{
    /**
     * List of available strategies
     * @var string
     */
    protected $availableStrategy = array(
        'access_token'       => 'OAuth2Provider/GrantTypeStrategy/AccessToken',
        'authorization_code' => 'OAuth2Provider/GrantTypeStrategy/AuthorizationCode',
    );

    /**
     * Concrete FQNS implementation of grant types taken from OAuthServer
     * @var array
     */
    protected $concreteClasses = array(
        'access_token'       => 'OAuth2\ResponseType\AccessToken',
        'authorization_code' => 'OAuth2\ResponseType\AuthorizationCode',
    );

    /**
     * Initialize an OAuth Response Type object
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $strategies      = $this->availableStrategy;
        $concreteClasses = $this->concreteClasses;

        return function ($strategyTypes, $serverKey) use ($serviceLocator, $strategies, $concreteClasses) {
            $container = $serviceLocator->get('OAuth2Provider/Containers/ResponseTypeContainer');

            foreach ($strategyTypes as $strategyName => $strategyParams) {
                if (is_array($strategyParams)) {
                    if (!isset($strategyParams['class'])) {
                        throw new Exception\InvalidServerException(sprintf(
                            "Class '%s' error: cannot find 'class' key in array",
                            __METHOD__
                        ));
                    }
                    $class  = $strategyParams['class'];
                    $params = isset($strategyParams['params']) ? $strategyParams['params'] : null;
                } elseif (is_string($strategyParams)) {
                    $class  = $strategyParams;
                    $params = null;
                } else {
                    $class  = null;
                    $params = null;
                }

                if (isset($class)) {
                    if ($serviceLocator->has($class)) {
                        $strategyParams = $serviceLocator->get($class);
                    } else {
                        /** maps the strategy type to a strategy **/
                        // a strategy key is available
                        if (isset($strategies[$strategyName])) {
                            $strategyContainerKey = $strategyName;
                            $strategy = $strategies[$strategyContainerKey];
                            if (!isset($params['storage'])) {
                                $params['storage'] = $strategyContainerKey;
                            }
                        } else {
                            // if class is a direct implementation of grant type class
                            if (in_array($class, $concreteClasses)) {
                                $strategyContainerKey = array_search($class, $concreteClasses);
                                $strategy = $strategies[$strategyContainerKey];
                            } else {
                                // look at the parent as our last check
                                $parentClass = get_parent_class($class);
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
                                $class
                            ));
                        }

                        // forward construction to grant type strategy
                        $strategy = $serviceLocator->get($strategy);
                        $strategyObj = $strategy($class, $params, $serverKey);
                    }
                }

                if (!$strategyObj instanceof ResponseTypeInterface) {
                    throw new Exception\InvalidClassException(sprintf(
                        "Class '%s' error: '%s' is not of GrantTypeInterface",
                        __METHOD__,
                        get_class($strategyObj)
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
        };
    }
}
