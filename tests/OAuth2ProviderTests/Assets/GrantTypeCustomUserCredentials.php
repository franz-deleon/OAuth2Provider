<?php
namespace OAuth2ProviderTests\Assets;

use OAuth2\GrantType\GrantTypeInterface;
use OAuth2\ResponseType\AccessTokenInterface;
use OAuth2\RequestInterface;
use OAuth2\ResponseInterface;

class GrantTypeCustomUserCredentials implements GrantTypeInterface
{
    public function getQuerystringIdentifier()
    {
    }

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
}