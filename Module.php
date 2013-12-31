<?php
namespace OAuth2Provider;

class Module
{
    public function onBootstrap($e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('route', function ($e) {
            $oauthConfig = $e
                ->getApplication()
                ->getServiceManager()
                ->get('OAuth2Provider/Options/Configuration');

            $router = $e->getRouter();
            $router->removeRoute('oauth2provider');

            $config  = $e->getApplication()->getConfig();
            $config['router']['routes']['oauth2provider']['child_routes'][0]['options']['route'] = "/{$oauthConfig->getVersion()}";

            $router->addRoute('oauth2provider', $config['router']['routes']['oauth2provider']);
        }, 100);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'OAuth2ProviderTests' => __DIR__ . '/tests/OAuth2ProviderTests',
                ),
            ),
        );
    }
}
