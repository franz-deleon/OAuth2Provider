<?php
namespace OAuth2Provider\Controller;

use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractRestfulController;

class UserCredentialsController extends AbstractRestfulController implements ControllerInterface
{
    public function authorizeAction()
    {
        return new JsonModel(array(
            'error' => 'Error: The authorize endpoint is not supported for user credentials.',
        ));
    }

    public function requestAction()
    {
        $server   = $this->getServiceLocator()->get('oauth2provider.server.main');
        $response = $server->handleTokenRequest();
        $params   = $response->getParameters();

        return new JsonModel($params);
    }

    public function resourceAction($scope = null)
    {
        $server        = $this->getServiceLocator()->get('oauth2provider.server.main');
        $isValid       = $server->verifyResourceRequest($scope);
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
