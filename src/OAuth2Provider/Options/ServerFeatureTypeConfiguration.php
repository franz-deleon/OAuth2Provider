<?php
namespace OAuth2Provider\Options;

use Zend\Stdlib\AbstractOptions;

class ServerFeatureTypeConfiguration extends AbstractOptions
{
    /**
     * The feature name to be used
     *
     * A list of available features can be found on:
     * 'Server Features' in module.php
     *
     * @var string
     */
    protected $name;

    /**
     * Parameter mapping for a strategy used for <$name>
     * @var array
     */
    protected $params = array();

	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @param field_type $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

	/**
     * @return the $params
     */
    public function getParams()
    {
        return $this->params;
    }

	/**
     * @param multitype: $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }
}
