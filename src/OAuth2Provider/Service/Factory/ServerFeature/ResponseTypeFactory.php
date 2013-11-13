<?php
namespace OAuth2Provider\Service\Factory\ServerFeature;

use OAuth2Provider\Exception;
use OAuth2Provider\Builder\StrategyBuilder;

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
     * The interface to validate against
     * @var string FQNS
     */
    protected $strategyInterface = 'OAuth2\ResponseType\ResponseTypeInterface';

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
        $interface       = $this->strategyInterface;

        return function ($strategyTypes, $serverKey) use ($serviceLocator, $strategies, $concreteClasses, $interface) {
            $strategy = new StrategyBuilder(
                $strategyTypes,
                $serverKey,
                $strategies,
                $concreteClasses,
                $serviceLocator->get('OAuth2Provider/Containers/ResponseTypeContainer'),
                $interface
            );
            return $strategy->initStrategyFeature($serviceLocator);
        };
    }
}
