<?php
namespace OAuth2Provider\Containers;

use Zend\Stdlib\ArrayStack;

class GrantTypeContainer extends ArrayStack
{
    public function getServerGrantTypes($server)
    {
        $array = $this->getArrayCopy();
        if (isset($array[$server])) {
            return $array[$server];
        }
    }

    public function getServerStorageInKey($server, $grantTypeKey)
    {
        $array = $this->getArrayCopy();
        if (isset($array[$server][$grantTypeKey])) {
            return $array[$server][$grantTypeKey];
        }
    }

    public function isServerStorageInKey($server, $grantTypeKey)
    {
        $array = $this->getArrayCopy();
        if (isset($array[$server][$grantTypeKey])) {
            return true;
        }
        return false;
    }
}
