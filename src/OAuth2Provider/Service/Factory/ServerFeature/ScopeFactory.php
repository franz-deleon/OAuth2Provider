<?php
namespace OAuth2Provider\Service\Factory\ServerFeature;

use Zend\ServiceManager;

class ScopeFactory implements ServiceManager\FactoryInterface
{
    /**
     * Initialize an OAuth Response Type object
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $availableStrategies = $this->availableStrategies;
        $concreteClasses     = $this->concreteClasses;
        $interface           = $this->strategyInterface;

        return function ($strategy, $serverKey) use (
            $availableStrategies,
            $concreteClasses,
            $interface,
            $serviceLocator
        ) {
            if (isset($strategy)) {
                // make sure the array being passed is of one strategy object only
                if (!is_array($strategy)) {
                    $strategy = array($strategy);
                }
                if (count($strategy) > 1) {
                    $shift = true;
                    foreach ($strategy as $element) {
                        if (!is_array($element)) {
                            $shift = false;
                            break;
                        }
                    }
                    if (true === $shift) {
                        $strategy = array_shift($strategy);
                    }
                    $strategy = array($strategy);
                }

                $strategy = new StrategyBuilder(
                    $strategy ?: array(),
                    $serverKey,
                    $availableStrategies,
                    $concreteClasses,
                    $serviceLocator->get('OAuth2Provider/Containers/TokenTypeContainer'),
                    $interface
                );
                $strategy = $strategy->initStrategyFeature($serviceLocator);

                // check if valid, if not explicitly return null
                if (!empty($strategy)) {
                    return array_shift($strategy);
                }
            }
        };
    }
}