<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Options\ClientAssertionType\HttpBasicConfigurations;

/**
 * HttpBasicConfigurations test case.
 */
class HttpBasicConfigurationsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HttpBasicConfigurations
     */
    private $HttpBasicConfigurations;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->HttpBasicConfigurations = new HttpBasicConfigurations(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->HttpBasicConfigurations = null;
        parent::tearDown();
    }

    /**
     * Tests HttpBasicConfigurations->getClientCredentialsStorage()
     */
    public function testGetClientCredentialsStorage()
    {
        $r = $this->HttpBasicConfigurations->getClientCredentialsStorage(/* parameters */);
        $this->assertNull($r);
    }

    /**
     * Tests HttpBasicConfigurations->setClientCredentialsStorage()
     */
    public function testSetClientCredentialsStorage()
    {
        $s = $this->HttpBasicConfigurations->setClientCredentialsStorage(new Assets\Storage\ClientCredentialsStorage());
        $this->assertSame($this->HttpBasicConfigurations, $s);

        $r = $this->HttpBasicConfigurations->getClientCredentialsStorage();
        $this->assertInstanceOf('OAuth2\Storage\ClientCredentialsInterface', $r);
    }

    /**
     * Tests HttpBasicConfigurations->getConfigs()
     */
    public function testGetConfigs()
    {
        $r = $this->HttpBasicConfigurations->getConfigs(/* parameters */);
        $this->assertEmpty($r);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests HttpBasicConfigurations->setConfigs()
     */
    public function testSetConfigs()
    {
        $s = $this->HttpBasicConfigurations->setConfigs(array('foo' => 'bar'));
        $this->assertSame($this->HttpBasicConfigurations, $s);

        $r = $this->HttpBasicConfigurations->getConfigs();
        $this->assertSame(array('foo' => 'bar'), $r);
    }
}
