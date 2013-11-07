<?php

namespace ApiOAuthProvider\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserCredentialsController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function RequestTokenAction()
    {
        $this->getServiceLocator()->get('apioauthprovider.server.main');
        //$r = $this->getServiceLocator()->get('OAuth/Storage/ClientCredentials')->getClientDetails(123);
        //var_dump($r);
        return new ViewModel();
    }
}
