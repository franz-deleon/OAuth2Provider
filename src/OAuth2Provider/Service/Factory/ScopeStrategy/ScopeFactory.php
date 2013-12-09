<?php
namespace OAuth2Provider\Service\Factory\ScopeStrategy;

use OAuth2Provider\Exception;
use OAuth2Provider\Lib\Utilities;

use OAuth2\Storage\ScopeInterface;

use Zend\ServiceManager;

class ScopeFactory implements ServiceManager\FactoryInterface
{
    /**
     * Identifiers
     * This will be used for defaults
     * @var string
     */
    const IDENTIFIER = 'scope';

    /**
     * Initialize an OAuth Scope
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
    */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($scopeClassName, $options, $serverKey) use ($serviceLocator) {
            $options = $serviceLocator->get('OAuth2Provider/Options/ScopeType/Scope')->setFromArray($options);

            $storage = null;
            $storageContainer = $serviceLocator->get('OAuth2Provider/Containers/StorageContainer');

            if (true === $options->getUseDefinedScopeStorage()
                && $storageContainer->isExistingServerContentInKey($serverKey, ScopeFactory::IDENTIFIER)
            ) {
                $storage = $storageContainer->getServerContentsFromKey($serverKey, ScopeFactory::IDENTIFIER);
            } else {
                // check for a user defined storage for scope
                $storage = Utilities::storageLookup(
                    $serverKey,
                    $options->getStorage(),
                    $storageContainer,
                    $serviceLocator
                );

                // attempt to assemble it manually
                if (null === $storage) {
                    $storage = array();
                    if (null !== $options->getDefaultScope()) {
                        $storage['default_scope'] = $options->getDefaultScope();
                    }

                    $clientSupportedScopes = $options->getClientSupportedScopes();
                    if (!empty($clientSupportedScopes)) {
                        $storage['client_supported_scopes'] = $clientSupportedScopes;
                    }

                    $clientDefaultScopes = $options->getClientDefaultScopes();
                    if (!empty($clientDefaultScopes)) {
                        $storage['client_default_scopes'] = $clientDefaultScopes;
                    }

                    $supportedScopes = $options->getSupportedScopes();
                    if (!empty($supportedScopes)) {
                        $storage['supported_scopes'] = $supportedScopes;
                    }
                }
            }

            if (is_object($storage) && !$storage instanceof ScopeInterface) {
                throw new Exception\InvalidClassException(sprintf(
                    "Error '%s': storage '%s' is of invalid type",
                    __METHOD__,
                    get_class($storage)
                ));
            }

            return new $scopeClassName($storage);
        };
    }
}
