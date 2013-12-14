<?php
namespace OAuth2Provider\Controller;

interface ControllerInterface
{
    /**
     * Authorize endpoint
     *
     * @param null|mixed
     * @return Zend\View\Model\JsonModel
     */
    public function authorizeAction();

    /**
     * Request endpoint
     * End point to request Access Tokens and Refresh Tokens
     *
     * @param null|mixed
     * @return Zend\View\Model\JsonModel
     */
    public function requestAction();

    /**
     * Resource Endpoint
     * End point where to validate the Access or Refresh Tokens
     *
     * @param null|mixed
     * @return Zend\View\Model\JsonModel
     */
    public function resourceAction();
}
