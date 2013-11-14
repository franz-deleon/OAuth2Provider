<?php
namespace OAuth2Provider\Containers;

use Zend\Stdlib\ArrayStack;

abstract class AbstractContainer extends ArrayStack implements ContainerInterface
{
    public function getServerContents($server)
    {
        $storageData = $this->getArrayCopy();
        if (isset($storageData[$server])) {
            return $storageData[$server];
        }
        return array();
    }

    public function getServerContentsFromKey($server, $key)
    {
        $storageData = $this->getArrayCopy();
        if (isset($storageData[$server][$key])) {
            return $storageData[$server][$key];
        }
        return array();
    }

    public function isExistingServerContentInKey($server, $key)
    {
        $storageData = $this->getArrayCopy();
        if (is_string($server)
            && is_string($key)
            && isset($storageData[$server][$key])
        ) {
            return true;
        }
        return false;
    }
}
