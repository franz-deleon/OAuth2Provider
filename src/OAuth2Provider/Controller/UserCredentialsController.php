<?php
namespace OAuth2Provider\Controller;

use OAuth2Provider\Exception;

use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractRestfulController;

class UserCredentialsController extends AbstractRestfulController
{
    public function AuthorizeAction()
    {
        throw new Exception\NotSupportedException(
            'Error: The authorize endpoint is not supported for user credentials.'
        );
        return new JsonModel();
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
        $isValid = $server->proxyVerifyResourceRequest();

        $params = array();
        $params['success'] = $isValid;

        if (!$isValid) {
            $params['error']   = 'Invalid Access Token';
            $params['message'] = 'The Access token has either expired or not valid';
        } else {
            $params['message'] = 'Valid Access Token';
        }

        return new JsonModel($params);
    }
}
