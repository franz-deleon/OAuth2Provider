<?php
namespace OAuth2ProviderTests\Assets;

use OAuth2\ResponseType\AccessTokenInterface;

class ResponseTypeCustomAccessToken implements AccessTokenInterface
{
    public function createAccessToken($client_id, $user_id, $scope = null, $includeRefreshToken = true)
    {
    }

    public function getAuthorizeResponse($params, $user_id = null)
    {

    }
}