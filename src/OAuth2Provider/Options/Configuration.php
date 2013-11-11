<?php
namespace OAuth2Provider\Options;

use Zend\Stdlib\AbstractOptions;

class Configuration extends AbstractOptions
{
    /**
     * The default server to use from the configuration
     * @var string
     */
    protected $mainServer = 'default';

    /**
     * Server list
     * @var array
     */
    protected $servers;

    /**
     * The Default controller strategy to use
     * @var string
     */
    protected $controller;

	/**
     * @return the $defaultServer
     */
    public function getMainServer()
    {
        return $this->mainServer;
    }

	/**
     * @param string $mainServer
     */
    public function setMainServer($mainServer)
    {
        if (!empty($mainServer)) {
            $this->mainServer = $mainServer;
        }
        return $this;
    }

	/**
     * @return the $server
     */
    public function getServers()
    {
        return $this->servers;
    }

	/**
     * @param field_type $server
     */
    public function setServers($servers)
    {
        $this->servers = $servers;
        return $this;
    }

	/**
     * @return the $controller
     */
    public function getController()
    {
        return $this->controller;
    }

	/**
     * @param field_type $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }
}
