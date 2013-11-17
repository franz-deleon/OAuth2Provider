<?php
namespace OAuth2Provider\Service\Factory\ScopeStrategy;

use OAuth2Provider\Lib\Utilities;

use Zend\ServiceManager;

class ScopeFactory implements ServiceManager\FactoryInterface
{
    /**
     * Identifiers
     * This will be used for defaults
     * @var string
     */
    const SCOPE_IDENTIFIER = 'scope';

    /**
     * Initialize an OAuth Authorization Code Response type
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
    */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $acceptedKeys = $this->acceptedKeys;
        return function ($scopeClassName, $options, $serverKey) use ($serviceLocator, $acceptedKeys) {
            $options = $serviceLocator->get('OAuth2Provider/Options/ScopeType/Scope')->setFromArray($options);

            $storage = null;
            $storageContainer = $serviceLocator->get('OAuth2Provider/Containers/StorageContainer');

            if (true === $options->getUseDefinedScopeStorage()
                && $storageContainer->isExistingServerContentInKey($serverKey, ScopeFactory::SCOPE_IDENTIFIER)
            ) {
                $storage = $storageContainer->getServerContentsFromKey($serverKey, ScopeFactory::SCOPE_IDENTIFIER);
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

            return new $scopeClassName($storage);
        };
    }
}
