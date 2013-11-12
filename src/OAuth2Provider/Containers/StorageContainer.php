<?php
namespace OAuth2Provider\Containers;

use Zend\Stdlib\ArrayStack;

class StorageContainer extends ArrayStack implements ContainerInterface
{
    public function getServerContents($server)
    {
        $storageData = $this->getArrayCopy();
        if (isset($storageData[$server])) {
            return $storageData[$server];
        }
    }

    public function getServerContentsFromKey($server, $key)
    {
        $storageData = $this->getArrayCopy();
        if (isset($storageData[$server][$key])) {
            return $storageData[$server][$key];
        }
    }

    public function isExistingServerContentInKey($server, $key)
    {
        if (is_string($server)
            && is_string($key)
            && null !== $this->getServerContentsFromKey($server, $key)
        ) {
            return true;
        }
        return false;
    }
}
