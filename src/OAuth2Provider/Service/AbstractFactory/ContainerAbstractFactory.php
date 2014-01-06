<?php
namespace OAuth2Provider\Service\AbstractFactory;

use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager;

class ContainerAbstractFactory implements ServiceManager\AbstractFactoryInterface
{
    /**
     * Pattern example (must be underscore separated):
     *
     *                      [server] [container] [container_key]
     * oauth2provider.server.server1.grant_type.user_credentials
     *
     * @var string
     */
    const REGEX_CONTAINER_PATTERN = '~^oauth2provider.server(?:.([a-zA-Z0-9_]+))(?:.(%s))(?:.([a-zA-Z0-9_]+))*$~';

    /**
     * List of available server containers
     * container keys/concrete classes mappings
     * @var array
     */
    protected $containers = array(
        'config'       => 'OAuth2Provider/Containers/ConfigContainer',
        'grant_type'   => 'OAuth2Provider/Containers/GrantTypeContainer',
        'reponse_type' => 'OAuth2Provider/Containers/ResponseTypeContainer',
        'scope_type'   => 'OAuth2Provider/Containers/ScopeTypeContainer',
        'storage'      => 'OAuth2Provider/Containers/StorageContainer',
        'token_type'   => 'OAuth2Provider/Containers/TokenTypeContainer',
        'client_assertion_type' => 'OAuth2Provider/Containers/ClientAssertionContainer',
    );

    /**
     * Matched Server from pattern
     * @var string
     */
    protected $server;

    /**
     * Matched Container from pattern
     * @var string
     */
    protected $container;

    /**
     * Matched Container Key from pattern
     * Note: not all container accept keys
     * @var string
     */
    protected $containerKey;

    /**
     * Actual container contents
     * @var array
     */
    protected $contents;

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
        // for performance, do a prelim check before checking against regex
        if (0 !== strpos($requestedName, 'oauth2provider.server.')) {
            return false;
        }

        $pattern = sprintf(static::REGEX_CONTAINER_PATTERN, implode('|', array_keys($this->containers)));
        if (preg_match($pattern, $requestedName, $matches) && !empty($matches)) {

            $this->serverKey = ($matches[1] === 'main')
                ? $serviceLocator->get('OAuth2Provider/Options/Configuration')->getMainServer()
                : $matches[1];
            $this->container    = $matches[2];
            $this->containerKey = isset($matches[3]) ? $matches[3] : null;

            // initialize the server
            if (!Utilities::hasSMInstance($serviceLocator, "oauth2provider.server.{$this->serverKey}")) {
                $serviceLocator->get("oauth2provider.server.{$this->serverKey}");
            }

            if (isset($this->containers[$this->container])) {
                $container = $serviceLocator->get($this->containers[$this->container]);
                if (isset($this->containerKey)) {
                    if ($container->isExistingServerContentInKey($this->serverKey, $this->containerKey)) {
                        $this->contents = $container->getServerContentsFromKey($this->serverKey, $this->containerKey);
                        return true;
                    } else {
                        return false;
                    }
                }

                $this->contents = $container->getServerContents($this->serverKey);
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
        return $this->contents;
    }
}
