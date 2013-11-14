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
     * Specific configuration mapping to comply with server
     * @var unknown
     */
    protected $keyMappings = array(
        'access_token' => 'token',
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

        return function ($strategyTypes, $serverKey)
            use ($serviceLocator, $strategies, $concreteClasses, $interface, $keyMappings
        ) {
            $strategy = new StrategyBuilder(
                $strategyTypes,
                $serverKey,
                $strategies,
                $concreteClasses,
                $serviceLocator->get('OAuth2Provider/Containers/ResponseTypeContainer'),
                $interface
            );
            $strategy = $strategy->initStrategyFeature($serviceLocator);

            // we need to map the key to eather 'code' for authorization_code and/or 'token' for access_token
            if (!empty($strategy)) {
                $return = array();
                foreach ($strategy as $key => $val) {
                    if (isset($keyMappings[$key])) {
                        $return[$keyMappings[$key]] = $val;
                    }
                }
                unset($strategy);
                return $return;
            }
        };
    }
}
