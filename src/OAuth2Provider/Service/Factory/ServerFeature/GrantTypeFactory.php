<?php
namespace OAuth2Provider\Service\Factory\ServerFeature;

use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;
use OAuth2Provider\Options\ServerFeatureTypeConfiguration;

use OAuth2\GrantType\GrantTypeInterface;

use Zend\ServiceManager;

class GrantTypeFactory implements ServiceManager\FactoryInterface
{
    /**
     * List of available strategies
     * @var string
     */
    protected $availableStrategy = array(
        'authorization_code' => 'OAuth2Provider/GrantTypeStrategy/AuthorizationCode',
        'client_credentials' => 'OAuth2Provider/GrantTypeStrategy/ClientCredentials',
        'jwt_bearer'         => 'OAuth2Provider/GrantTypeStrategy/JwtBearer',
        'refresh_token'      => 'OAuth2Provider/GrantTypeStrategy/RefreshToken' ,
        'user_credentials'   => 'OAuth2Provider/GrantTypeStrategy/UserCredentials',
    );

    /**
     * Concrete FQNS implementation of grant types taken from OAuthServer
     * @var array
     */
    protected $concreteClasses = array(
        'authorization_code' => 'OAuth2\GrantType\AuthorizationCode',
        'client_credentials' => 'OAuth2\GrantType\ClientCredentials',
        'jwt_bearer'         => 'OAuth2\GrantType\JwtBearer',
        'refresh_token'      => 'OAuth2\GrantType\RefreshToken',
        'user_credentials'   => 'OAuth2\GrantType\UserCredentials',
    );

    /**
     * Initialize an OAuth Grant Type object
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $strategies      = $this->availableStrategy;
        $concreteClasses = $this->concreteClasses;

        return function ($grantTypes, $serverKey) use ($serviceLocator, $strategies, $concreteClasses) {
            $grantTypeContainer = $serviceLocator->get('OAuth2Provider/Containers/GrantTypeContainer');

            foreach ($grantTypes as $grantTypeName => $grantType) {
                if (is_array($grantType)) {
                    $featureConfig = new ServerFeatureTypeConfiguration($grantType);
                    if (!$featureConfig->getName()) {
                        throw new Exception\InvalidServerException(sprintf(
                            "Class '%s' error: cannot find 'name' key in array",
                            __METHOD__
                        ));
                    }
                    $featureName   = $featureConfig->getName();
                    $featureParams = $featureConfig->getParams();
                } elseif (is_string($grantType)) {
                    $featureName   = $grantType;
                    $featureParams = null;
                } else {
                    $featureName   = null;
                    $featureParams = null;
                }

                if (isset($featureName)) {
                    if ($serviceLocator->has($featureName)) {
                        $grantType = $serviceLocator->get($featureName);
                    } else {
                        /** maps the grant type to a strategy **/
                        // a strategy key is available
                        if (isset($strategies[$grantTypeName])) {
                            $grantTypeKey = $grantTypeName;
                            $strategy     = $strategies[$grantTypeKey];
                            if (!isset($featureParams['storage'])) {
                                $featureParams['storage'] = $grantTypeKey;
                            }
                        } else {
                            // if class is a direct implementation of grant type class
                            if (in_array($featureName, $concreteClasses)) {
                                $grantTypeKey = array_search($featureName, $concreteClasses);
                                $strategy = $strategies[$grantTypeKey];
                            } else {
                                // look at the parent as our last check
                                $parentClass = get_parent_class($featureName);
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
                                $featureName
                            ));
                        }

                        // forward construction to grant type strategy
                        $grantTypeStrategy = $serviceLocator->get($strategy);
                        $grantType = $grantTypeStrategy($featureName, $featureParams, $serverKey);
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
        };
    }
}
