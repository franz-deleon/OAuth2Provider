<?php
namespace OAuth2Provider\Controller;

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
        //echo $this->getServiceLocator()->get('franz');//oauth2provider.server.main
        //$r = $this->getServiceLocator()->get('OAuth/Storage/ClientCredentials')->getClientDetails(123);
        //var_dump($r);
        return new ViewModel();
    }
}
