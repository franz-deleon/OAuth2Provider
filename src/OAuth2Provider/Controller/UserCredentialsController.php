<?php
namespace OAuth2Provider\Controller;

use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractRestfulController;

use Zend\Mvc\Controller\AbstractActionController;

class UserCredentialsController extends AbstractRestfulController
//class UserCredentialsController extends AbstractActionController
{
    public function AuthorizeAction()
    {
        // not used;
        return new JsonModel();
    }

    public function RequestAction()
    {
        $server = $this->getServiceLocator()->get('oauth2provider.server.main');
        $response = $server->handleTokenRequest(\OAuth2\Request::createFromGlobals());
        $params   = $response->getParameters();

        return new JsonModel($params);
    }

    public function ResourceAction()
    {
        $server = $this->getServiceLocator()->get('oauth2provider.server.main');
        $isValid  = $server->verifyResourceRequest(\OAuth2\Request::createFromGlobals());

        return new JsonModel(array(
            'success' => $isValid,
            'message' => $isValid === true ? 'Valid Access Token' : 'Invalid Access Token',
        ));
    }
}
