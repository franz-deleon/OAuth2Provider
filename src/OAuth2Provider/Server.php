<?php
namespace OAuth2Provider;

use Zend\ServiceManager;
use OAuth2\Server as OAuth2Server;
use ReflectionClass;

class Server implements ServiceManager\ServiceManagerAwareInterface, ServerInterface
{
    /**
     * @var \OAuth2\Server
     */
    protected $server;

    /**
     * @var ServiceManager\ServiceManager
     */
    protected $serviceManager;

    /**
     * @var \OAuth2\Request
     */
    protected $request;

    /**
     * @var \OAuth2\Response
     */
    protected $response;

    /**
     * Forwards the method calls to OAuth2\Server
     * @param string $method
     * @param array  $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        $callable = array($this->getOAuth2Server(), $method);
        if (is_callable($callable)) {
            return call_user_func_array($callable, $args);
        }
    }

    public function handleTokenRequest()
    {
        return $this->getOAuth2Server()->handleTokenRequest($this->getRequest(), $this->getResponse());
    }

    public function verifyResourceRequest($scope = null)
    {
        return $this->getOAuth2Server()->verifyResourceRequest($this->getRequest(), $this->getResponse(), $scope);
    }

    public function getAccessTokenData()
    {
        return $this->getOAuth2Server()->getAccessTokenData($this->getRequest(), $this->getResponse());
    }

    public function grantAccessToken()
    {
        return $this->getOAuth2Server()->grantAccessToken($this->getRequest(), $this->getResponse());
    }

    public function handleAuthorizeRequest($isAuthorized, $userId = null)
    {
        return $this->getOAuth2Server()->handleAuthorizeRequest($this->getRequest(), $this->getResponse(), $isAuthorized, $userId);
    }

    public function validateAuthorizeRequest()
    {
        return $this->getOAuth2Server()->validateAuthorizeRequest($this->getRequest(), $this->getResponse());
    }

    public function getOAuth2Server()
    {
        return $this->server;
    }

    public function setOAuth2Server(OAuth2Server $server)
    {
        $this->server = $server;
        return $this;
    }

    public function getRequest()
    {
        if (null === $this->request) {
            $this->request = $this->serviceManager->get('oauth2provider.server.main.request');
        }
        return $this->request;
    }

    public function getResponse()
    {
        if (null === $this->response) {
            $this->response = $this->serviceManager->get('oauth2provider.server.main.response');
        }
        return $this->response;
    }

    public function setServiceManager(ServiceManager\ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
}