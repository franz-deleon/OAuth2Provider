<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Options\TokenType\BearerConfigurations;

/**
 * BearerConfigurations test case.
 */
class BearerConfigurationsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BearerConfigurations
     */
    private $BearerConfigurations;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->BearerConfigurations = new BearerConfigurations(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->BearerConfigurations = null;
        parent::tearDown();
    }

    /**
     * Tests BearerConfigurations->getConfigs()
     */
    public function testGetConfigs()
    {
        $r = $this->BearerConfigurations->getConfigs(/* parameters */);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests BearerConfigurations->setConfigs()
     */
    public function testSetConfigs()
    {
        $s = $this->BearerConfigurations->setConfigs(array('options'));
        $this->assertSame($this->BearerConfigurations, $s);

        $r = $this->BearerConfigurations->getConfigs();
        $this->assertSame(array('options'), $r);
    }
}

