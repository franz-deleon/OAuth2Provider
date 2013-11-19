<?php
namespace OAuth2Provider\Containers;

use OAuth2Provider\Exception\ErrorException;

class RequestContainer extends AbstractContainer
{
    public function getServerContentsFromKey($server, $key)
    {
       throw new ErrorException(sprintf(
            "Error %s: method '%s' not implemented for '%s'",
            __METHOD__,
            __FUNCTION__,
            __CLASS__
       ));
    }

    public function isExistingServerContentInKey($server, $key)
    {
        return false;
    }
}
