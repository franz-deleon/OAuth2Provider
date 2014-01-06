<?php
namespace OAuth2ProviderTests\Assets;

use OAuth2Provider\Controller\ControllerInterface;

use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractRestfulController;

class ImplementingController extends AbstractRestfulController implements ControllerInterface
{
    public function authorizeAction()
    {
        return new JsonModel();
    }

    public function requestAction()
    {
        return new JsonModel();
    }

    public function resourceAction($scope = null)
    {
        return new JsonModel();
    }
}
