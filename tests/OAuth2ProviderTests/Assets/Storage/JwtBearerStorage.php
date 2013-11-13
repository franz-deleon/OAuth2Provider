<?php
namespace OAuth2ProviderTests\Assets\Storage;

use OAuth2\Storage\JwtBearerInterface;

class JwtBearerStorage implements JwtBearerInterface
{
    /**
     * Get the public key associated with a client_id
     *
     * @param $client_id
     * Client identifier to be check with.
     *
     * @return
     * STRING Return the public key for the client_id if it exists, and MUST return FALSE if it doesn't.
     * @endcode
     */
    public function getClientKey($client_id, $subject)
    {

    }
}
