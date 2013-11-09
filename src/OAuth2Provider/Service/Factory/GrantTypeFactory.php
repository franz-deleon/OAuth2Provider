<?php
namespace OAuth2Provider\Service\Factory;

use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use OAuth2\GrantType\GrantTypeInterface;

use Zend\ServiceManager;
use OAuth2Provider\Exception\InvalidClassException;

class GrantTypeFactory implements ServiceManager\FactoryInterface
{
    protected $availableStrategy = array(
        'authorization_code' => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\AuthorizationCodeFactory',
        'client_credentials' => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\ClientCredentialsFactory',
        'jwt_bearer'         => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\JwtBearerFactory',
        'refresh_token'      => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\RefreshTokenFactory' ,
        'user_credentials'   => 'OAuth2Provider\Service\Factory\GrantTypeStrategy\UserCredentialsFactory',
    );

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
        $strategies = $this->availableStrategy;
        $concreteClasses = $this->concreteClasses;

        return function ($grantType, $grantTypeName, $serverKey) use ($serviceLocator, $strategies, $concreteClasses) {

            if (!is_object($grantType)) {
                if (is_array($grantType)) {
                    if (!isset($grantType['class'])) {
                        throw new Exception\InvalidServerException(sprintf(
                            "Class '%s' error: cannot find 'class' key in array",
                            __METHOD__
                        ));
                    }
                    $class = $grantType['class'];
                } elseif (is_string($grantType)) {
                    $class = $grantType;
                }

                if ($serviceLocator->has($class)) {
                    $grantType = $serviceLocator->get($class);
                } else {
                    /** maps the grant type to a strategy **/
                    // a strategy key is available
                    if (isset($strategies[$grantTypeName])) {
                        $strategy = $strategies[$grantTypeName];
                    } else {
                        if (is_string($class)) {
                            // if class is a direct implementation in of grant type classes
                            if (in_array($class, $concreteClasses)) {
                                $strategy = array_flip($concreteClasses);
                                $strategy = $strategy[$class];
                                $strategy = $strategies[$strategy];
                            } else {
                                // look at the parent as our last hoorah
                                $parentClass = get_parent_class($class);
                                if (in_array($parentClass, $concreteClasses)) {
                                    $strategy = array_flip($concreteClass);
                                    $strategy = $strategy[$parentClass];
                                    $strategy = $strategies[$strategy];
                                }
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
                    $grantTypeStrategy($class, $serverKey);
                }
            }

            if (!$grantType instanceof GrantTypeInterface) {
                throw new Exception\InvalidClassException(sprintf(
                    "Class '%s' error: '%s' is not of GrantTypeInterface",
                    __METHOD__,
                    get_class($grantType)
                ));
            }

            $grantTypeContainer = $serviceLocator->get('OAuth2Provider/Containers/GrantTypeContainer');
            $grantTypeContainer[$serverKey][$grantTypeName] = $grantType;

            return $grantType;
        };
    }
}
