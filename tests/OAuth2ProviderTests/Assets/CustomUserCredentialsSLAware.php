<?php
namespace OAuth2ProviderTests\Assets;

use OAuth2\GrantType\GrantTypeInterface;
use OAuth2\ResponseType\AccessTokenInterface;
use OAuth2\RequestInterface;
use OAuth2\ResponseInterface;

use Zend\ServiceManager;

use OAuth2\GrantType\UserCredentials;

class CustomUserCredentialsSLAware extends UserCredentials implements GrantTypeInterface, ServiceManager\ServiceLocatorAwareInterface
{
    public function validateRequest(RequestInterface $request, ResponseInterface $response)
    {
    }

    public function getClientId()
    {
    }

    public function getUserId()
    {
    }

    public function getScope()
    {
    }

    public function createAccessToken(AccessTokenInterface $accessToken, $client_id, $user_id, $scope)
    {
    }

    public function setServiceLocator(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
    */
    public function getServiceLocator()
    {
    }
}