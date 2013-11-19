<?php
namespace OAuth2Provider\Service\AbstractFactory;

use OAuth2\Request;

use Zend\ServiceManager;

class RequestAbstractFactory implements ServiceManager\AbstractFactoryInterface
{
    /**
     * @var string
     */
    const REGEX_REQUEST_PATTERN = '~^oauth2provider.server.([a-zA-Z0-9_]+).request$~';

    /**
     * @var array
     */
    protected $serverConfig;

    /**
     * @var string
     */
    protected $serverKey;

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceManager\ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (preg_match(static::REGEX_REQUEST_PATTERN, $requestedName, $serverKeyMatch)
            && !empty($serverKeyMatch[1])
        ) {
            $this->serverKey = $serverKeyMatch[1];
            // do not create the request if there is no server defined yet
            if ($serviceLocator->has("oauth2provider.server.{$this->serverKey}")) {
                return true;
            }
        }

        return false;
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     */
    public function createServiceWithName(ServiceManager\ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $requestContainer = $serviceLocator->get('OAuth2Provider/Containers/RequestContainer');
        $requestContainer[$this->serverKey] = Request::createFromGlobals();

        return $requestContainer->getServerContents($this->serverKey);
    }
}
