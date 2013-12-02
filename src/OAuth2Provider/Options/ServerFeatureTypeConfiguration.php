<?php
namespace OAuth2Provider\Options;

use Zend\Stdlib\AbstractOptions;

class ServerFeatureTypeConfiguration extends AbstractOptions
{
    protected $__strictMode__ = false;

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
    protected $options = array();

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
     * @return the $options
     */
    public function getOptions()
    {
        return $this->options;
    }

	/**
     * @param multitype: $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }
}
