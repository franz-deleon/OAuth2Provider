<?php
namespace OAuth2Provider\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractRestfulController;

class UserCredentialsController extends AbstractRestfulController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function RequestTokenAction()
    {
        $server = $this->getServiceLocator()->get('oauth2provider.server.main');
// $x = $this->getServiceLocator()->get('request');var_dump($x->getPost('grant_type'));
        $server->handleTokenRequest(\OAuth2\Request::createFromGlobals())->send();
        //var_dump($r);

        //$request = \OAuth2\Request::createFromGlobals();

        //$userCred = $this->getServiceLocator()->get('ApiOauth2Server/Storage/UserCredentials')->checkUserCredentials('kelmadics', 'abc123');
//var_dump($userCred);
//         $this->getServiceLocator()->get('ApiOauth2Server/Storage/UserCredentials')->getUserDetails('kelmadics');

//         $r = $this->getServiceLocator()->get('ApiOauth2Server/Storage/AccessToken')->getAccessToken('123');



//         //$this->getServiceLocator()->get('ApiOauth2Server/Storage/AccessToken')->setAccessToken('456', 1, 1, '2014-05-05');

//         $r = $this->getServiceLocator()->get('ApiOauth2Server/Storage/ClientCredentials')->checkClientCredentials(1, 123);



        return new ViewModel();
    }
}
