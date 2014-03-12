<?php
namespace OAuth2ProviderTests\Options\GrantType;

use OAuth2Provider\Options\GrantType\ClientCredentialsConfigurations;

/**
 * ClientCredentialsConfigurations test case.
 */
class ClientCredentialsConfigurationsTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var ClientCredentialsConfigurations
     */
    private $ClientCredentialsConfigurations;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ClientCredentialsConfigurations = new ClientCredentialsConfigurations(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ClientCredentialsConfigurations = null;
        parent::tearDown();
    }

    /**
     * Tests ClientCredentialsConfigurations->getClientCredentialsStorage()
     */
    public function testGetClientCredentialsStorage()
    {
        $r = $this->ClientCredentialsConfigurations->getClientCredentialsStorage(/* parameters */);
        $this->assertNull($r);
    }

    /**
     * Tests ClientCredentialsConfigurations->setClientCredentialsStorage()
     */
    public function testSetClientCredentialsStorage()
    {
        $r = $this->ClientCredentialsConfigurations->setClientCredentialsStorage(new \stdClass());
        $this->assertSame($this->ClientCredentialsConfigurations, $r);

        $r = $this->ClientCredentialsConfigurations->getClientCredentialsStorage();
        $this->assertEquals(new \stdClass(), $r);
    }

    /**
     * Tests ClientCredentialsConfigurations->getConfigs()
     */
    public function testGetConfigs()
    {
        $r = $this->ClientCredentialsConfigurations->getConfigs(/* parameters */);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests ClientCredentialsConfigurations->setConfigs()
     */
    public function testSetConfigs()
    {
        $r = $this->ClientCredentialsConfigurations->setConfigs(array('configs'));
        $this->assertSame($this->ClientCredentialsConfigurations, $r);

        $r = $this->ClientCredentialsConfigurations->getConfigs();
        $this->assertEquals(array('configs'), $r);
    }
}

