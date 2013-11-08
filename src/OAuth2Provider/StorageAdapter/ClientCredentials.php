<?php
namespace OAuth2Provider\StorageAdapter;

use OAuth2\Storage\ClientCredentialsInterface;

class ClientCredentials extends AbstractStorageAdapter implements ClientCredentialsInterface
{
    public function getClientDetails($clientId)
    {
        $clientData = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default')
            ->getRepository('OAuth2Provider\Model\Entity\OAuthClient')
            ->getClientDetails($clientId);

        if (!empty($clientData)) {
            $camelcaseFilter = $this->getServiceLocator()->get('FilterManager')->get('wordcamelcasetounderscore');
            //$hydrator   = $this->getServiceLocator()->get('HydratorManager')->get('DoctrineModule\Stdlib\Hydrator\DoctrineObject');
            //$clientData = $hydrator->extract($clientData);

            $camelcasedKeys = array_map(function ($val) use ($camelcaseFilter) {
                return strtolower($camelcaseFilter->filter($val));
            }, array_keys($clientData));

            return array_combine($camelcasedKeys, $clientData);
        }

        return false;
    }

    public function checkClientCredentials($client_id, $client_secret = NULL)
    {
        $client = $this->getClientDetails($client_id);

        if ($client) {
            return $client['client_secret'] === sha1($client_secret);
        }
        return false;
    }

    public function checkRestrictedGrantType($client_id, $grant_type)
    {
        // we do not support different grant types per client in this example
        return true;
    }
}
