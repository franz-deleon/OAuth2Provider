<?php
namespace OAuth2Provider\Containers;

use Zend\Stdlib\ArrayStack;

class StorageContainer extends ArrayStack
{
    public function getServerStorages($server)
    {
        $array = $this->getArrayCopy();
        if (isset($array[$server])) {
            return $array[$server];
        }
    }

    public function getServerStorageInKey($server, $storageKey)
    {
        $array = $this->getArrayCopy();
        if (isset($array[$server][$storageKey])) {
            return $array[$server][$storageKey];
        }
    }
}
