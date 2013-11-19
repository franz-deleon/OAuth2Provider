<?php
namespace OAuth2Provider\Service\AbstractFactory;

use Zend\ServiceManager;

class ContainerAbstractFactory implements ServiceManager\AbstractFactoryInterface
{
    /**
     * @var string
     */
    const REGEX_PATTERN = '~^oauth2provider.server(?:=([a-zA-Z0-9_]+))(?:.(%s))(?:=([a-zA-Z0-9_]+))*$~';

    /**
     * List of available containers
     * @var array
     */
    protected $containers = array(
        'config'       => 'OAuth2Provider/Containers/ConfigContainer',
        'grant_type'   => 'OAuth2Provider/Containers/GrantTypeContainer',
        'reponse_type' => 'OAuth2Provider/Containers/ResponseTypeContainer',
        'scope_type'   => 'OAuth2Provider/Containers/ScopeTypeContainer',
        'storage'      => 'OAuth2Provider/Containers/StorageContainer',
        'token_type'   => 'OAuth2Provider/Containers/TokenTypeContainer',
    );

    protected $containerKey;

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
        // for performance, do a prelim check before checking agains regex
        if (0 !== strpos($requestedName, 'oauth2provider')) {
            return false;
        }

        $pattern = sprintf(static::REGEX_PATTERN, implode('|', array_keys($this->containers)));
        if (preg_match($pattern, $requestedName, $matches) && !empty($matches)) {

            $this->serverKey = ($matches[1] === 'main')
                ? $serviceLocator->get('OAuth2Provider/Options/Configuration')->getMainServer()
                : $matches[1];

            $container = $matches[2];
            $containerKey = isset($matches[3]) ? $matches[3] : null;

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
