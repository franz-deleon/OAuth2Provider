<?php
namespace OAuth2Provider\Controller;

use OAuth2Provider\Exception;

use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractRestfulController;

class UserCredentialsController extends AbstractRestfulController
{
    public function AuthorizeAction()
    {
        return new JsonModel(array(
            'error' => 'Error: The authorize endpoint is not supported for user credentials.',
        ));
    }

    public function RequestAction()
    {
        $server   = $this->getServiceLocator()->get('oauth2provider.server.main');
        $response = $server->proxyHandleTokenRequest();
        $params   = $response->getParameters();

        return new JsonModel($params);
    }

    public function ResourceAction()
    {
        $server  = $this->getServiceLocator()->get('oauth2provider.server.main');
        $isValid       = $server->proxyVerifyResourceRequest();
        $responseParam = $server->getResponse()->getParameters();

        $params = array();
        $params['success'] = $isValid;

        if (!$isValid) {
            $params['error']   = isset($responseParam['error']) ? $responseParam['error'] : "Invalid Request";
            $params['message'] = isset($responseParam['error_description']) ? $responseParam['error_description'] : "Access Token is invalid";
        } else {
            $params['message'] = "Access Token is Valid!";
        }

        return new JsonModel($params);
    }
}
