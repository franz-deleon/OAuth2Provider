<?php
namespace OAuth2Provider;

use OAuth2\Server as OAuth2Server;

interface ServerInterface
{
    /**
     * Set the Oauth2 server instance
     *
     * @see OAuth2\Server
     * @param Server $server
     */
    public function setOAuth2Server(OAuth2Server $server);
}
