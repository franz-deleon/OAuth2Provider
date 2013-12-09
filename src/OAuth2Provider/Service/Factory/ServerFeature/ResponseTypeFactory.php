<?php
namespace OAuth2Provider\Service\Factory\ServerFeature;

use OAuth2Provider\Builder\StrategyBuilder;
use OAuth2Provider\Service\Factory\ResponseTypeStrategy;

use Zend\ServiceManager;

class ResponseTypeFactory implements ServiceManager\FactoryInterface
{
    /**
     * List of available strategies
     * @var string
     */
    protected $availableStrategy = array(
        ResponseTypeStrategy\AccessTokenFactory::IDENTIFIER       => 'OAuth2Provider/GrantTypeStrategy/AccessToken',
        ResponseTypeStrategy\AuthorizationCodeFactory::IDENTIFIER => 'OAuth2Provider/GrantTypeStrategy/AuthorizationCode',
    );

    /**
     * Concrete FQNS implementation of grant types taken from OAuthServer
     * @var array
     */
    protected $concreteClasses = array(
        ResponseTypeStrategy\AccessTokenFactory::IDENTIFIER       => 'OAuth2\ResponseType\AccessToken',
        ResponseTypeStrategy\AuthorizationCodeFactory::IDENTIFIER => 'OAuth2\ResponseType\AuthorizationCode',
    );

    /**
     * Specific configuration mapping to comply with server
     * @var array
     */
    protected $keyMappings = array(
        'access_token'       => 'token',
        'authorization_code' => 'code',
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
        $keyMappings     = $this->keyMappings;

        return function ($strategyTypes, $serverKey) use (
            $serviceLocator,
            $strategies,
            $concreteClasses,
            $interface,
            $keyMappings
        ) {
            $strategy = new StrategyBuilder(
                $strategyTypes,
                $serverKey,
                $strategies,
                $concreteClasses,
                $serviceLocator->get('OAuth2Provider/Containers/ResponseTypeContainer'),
                $interface
            );

            // map keys to comply with server
            $result = array();
            foreach ($strategy->initStrategyFeature($serviceLocator) as $key => $val) {
                if (isset($keyMappings[$key])) {
                    $result[$keyMappings[$key]] = $val;
                }
            }
            unset($strategy);

            return $result;
        };
    }
}
