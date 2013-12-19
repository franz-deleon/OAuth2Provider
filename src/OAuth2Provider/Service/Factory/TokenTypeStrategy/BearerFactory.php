<?php
namespace OAuth2Provider\Service\Factory\TokenTypeStrategy;

use OAuth2Provider\Exception;

use Zend\ServiceManager;

class BearerFactory implements ServiceManager\FactoryInterface
{
    /**
     * Identifiers
     * This will be used for defaults
     * @var string
     */
    const IDENTIFIER = 'bearer';

    /**
     * Accepted config keys for bearer
     * @var array
     */
    protected $acceptedKeys = array(
        'token_param_name',
        'token_bearer_header_name',
    );

    /**
     * Initialize an OAuth Authorization Code Response type
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $acceptedKeys = $this->acceptedKeys;
        return function ($bearerClassName, $options, $serverKey) use ($serviceLocator, $acceptedKeys) {
            $options = $serviceLocator->get('OAuth2Provider/Options/TokenType/Bearer')->setFromArray($options);
            $configs = $options->getConfigs();

            foreach (array_keys($configs) as $key) {
                if (!in_array($key, $acceptedKeys)) {
                    throw new Exception\InvalidServerException(sprintf(
                        "Class '%s' error: configuration '%s' is not valid. Should be one of: ['%s']",
                        __METHOD__,
                        $key,
                        implode("', '", $acceptedKeys)
                    ));
                }
            }

            return new $bearerClassName($configs);
        };
    }
}
