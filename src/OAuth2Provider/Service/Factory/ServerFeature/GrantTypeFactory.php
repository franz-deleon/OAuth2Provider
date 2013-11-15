<?php
namespace OAuth2Provider\Service\Factory\ServerFeature;

use OAuth2Provider\Builder\StrategyBuilder;

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
     * The interface to validate against
     * @var string FQNS
     */
    protected $strategyInterface = 'OAuth2\GrantType\GrantTypeInterface';

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
        $interface       = $this->strategyInterface;

        return function ($strategyTypes, $serverKey) use ($serviceLocator, $strategies, $concreteClasses, $interface) {
            $strategy = new StrategyBuilder(
                $strategyTypes,
                $serverKey,
                $strategies,
                $concreteClasses,
                $serviceLocator->get('OAuth2Provider/Containers/GrantTypeContainer'),
                $interface
            );
            return $strategy->initStrategyFeature($serviceLocator);
        };
    }
}
