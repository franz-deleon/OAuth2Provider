<?php
namespace OAuth2Provider;

use OAuth2\ResponseInterface;
use OAuth2\RequestInterface;

use OAuth2\Server as OAuth2Server;

use Zend\ServiceManager;

class Server extends OAuth2Server implements ServiceManager\ServiceManagerAwareInterface
{
    protected $serviceManager;
    protected $request;
    protected $response;

    public function proxyHandleTokenRequest()
    {
        return parent::handleTokenRequest($this->getRequest(), $this->getResponse());
    }

    public function proxyVerifyResourceRequest($scope = null)
    {
        return parent::verifyResourceRequest($this->getRequest(), $this->getResponse(), $scope);
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