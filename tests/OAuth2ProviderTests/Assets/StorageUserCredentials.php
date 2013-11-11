<?php
namespace OAuth2ProviderTests\Assets;

use OAuth2\Storage\UserCredentialsInterface;

class StorageUserCredentials implements UserCredentialsInterface
{
    public function checkUserCredentials($username, $password)
    {
    }

    public function getUserDetails($username)
    {
    }
}
