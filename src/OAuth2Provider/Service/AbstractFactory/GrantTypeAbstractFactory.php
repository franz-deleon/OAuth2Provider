<?php
namespace OAuth2Provider\Service\AbstractFactory;

use Zend\ServiceManager;

class GrantTypeAbstractFactory implements ServiceManager\AbstractFactoryInterface
{
    /**
     * @var string
     */
    const REGEX_GRANTTYPE_PATTERN = '~^oauth2provider.server.([a-zA-Z0-9_]+).granttype.([a-zA-Z0-9_]+)$~';

    /**
     * @var string
     */
    protected $serverKey;
    protected $grantTypeKey;

    /**
     * @var array
     */
    protected $grantTypeContainer;

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
        if (preg_match(static::REGEX_GRANTTYPE_PATTERN, $requestedName, $matches)
            && !empty($matches[2])
        ) {
            $this->serverKey = ($matches[1] === 'main')
                ? $serviceLocator->get('OAuth2Provider/Options/Configuration')->getMainServer()
                : $matches[1];
            $this->grantTypeKey = $matches[2];

            $this->grantTypeContainer = $serviceLocator->get('OAuth2Provider/Containers/GrantTypeContainer');
            if ($this->grantTypeContainer->isExistingServerContentInKey($this->serverKey, $this->grantTypeKey)) {
                return true;
            }

            // attempt to initialize the server then check for the grant type key again
            $serviceLocator->get("oauth2provider.server.{$this->serverKey}");
            if ($this->grantTypeContainer->isExistingServerContentInKey($this->serverKey, $this->grantTypeKey)) {
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
        return $this->grantTypeContainer->getServerContentsFromKey($this->serverKey, $this->grantTypeKey);
    }
}
