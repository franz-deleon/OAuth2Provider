<?php
namespace OAuth2ProviderTests\Assets;

use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractRestfulController;

class RegularController extends AbstractRestfulController
{
    public function indexAction()
    {
        return new JsonModel(array(
            'error' => 'errorneous',
        ));
    }
}
