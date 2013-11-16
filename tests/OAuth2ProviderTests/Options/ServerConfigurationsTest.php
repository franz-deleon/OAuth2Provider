<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Options\ServerConfigurations;

/**
 * ServerConfigurations test case.
 */
class ServerConfigurationsTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var ServerConfigurations
     */
    private $ServerConfigurations;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ServerConfigurations = new ServerConfigurations(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ServerConfigurations = null;
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }

    /**
     * Tests ServerConfigurations->getConfig()
     */
    public function testGetConfigs()
    {
        $r = $this->ServerConfigurations->getConfigs(/* parameters */);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests ServerConfigurations->setConfig()
     */
    public function testSetConfigs()
    {
        $r = $this->ServerConfigurations->setConfigs(array());
        $this->assertSame($this->ServerConfigurations, $r);
    }

    /**
     * Tests ServerConfigurations->setConfig()
     */
    public function testSetConfigsReturnsExpected()
    {
        $this->ServerConfigurations->setConfigs(array('options'));
        $r = $this->ServerConfigurations->getConfigs();
        $this->assertSame(array('options'), $r);
    }

    /**
     * Tests ServerConfigurations->getStorages()
     */
    public function testGetStorages()
    {
        $r = $this->ServerConfigurations->getStorages(/* parameters */);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests ServerConfigurations->setStorages()
     */
    public function testSetStorages()
    {
        $r = $this->ServerConfigurations->setStorages(array());
        $this->assertSame($this->ServerConfigurations, $r);
    }

    /**
     * Tests ServerConfigurations->setStorages()
     */
    public function testSetStoragesReturnsExpected()
    {
        $this->ServerConfigurations->setStorages(array('storage1'));
        $r = $this->ServerConfigurations->getStorages();
        $this->assertEquals(array('storage1'), $r);
    }

    /**
     * Tests ServerConfigurations->getGrantTypes()
     */
    public function testGetGrantTypes()
    {
        $r = $this->ServerConfigurations->getGrantTypes(/* parameters */);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests ServerConfigurations->setGrantTypes()
     */
    public function testSetGrantTypes()
    {
        $r = $this->ServerConfigurations->setGrantTypes(array());
        $this->assertSame($this->ServerConfigurations, $r);
    }

    /**
     * Tests ServerConfigurations->setGrantTypes()
     */
    public function testSetGrantTypesReturnsExpected()
    {
        $this->ServerConfigurations->setGrantTypes(array('a'));
        $r = $this->ServerConfigurations->getGrantTypes();
        $this->assertSame(array('a'), $r);
    }

    /**
     * Tests ServerConfigurations->getResponseTypes()
     */
    public function testGetResponseTypes()
    {
        $r = $this->ServerConfigurations->getResponseTypes(/* parameters */);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests ServerConfigurations->setResponseTypes()
     */
    public function testSetResponseTypes()
    {
        $r = $this->ServerConfigurations->setResponseTypes(array());
        $this->assertSame($this->ServerConfigurations, $r);
    }

    /**
     * Tests ServerConfigurations->getResponseTypes()
     */
    public function testSetResponseTypesReturnsExpected()
    {
        $r = $this->ServerConfigurations->getResponseTypes(/* parameters */);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests ServerConfigurations->getTokenType()
     */
    public function testGetTokenType()
    {
        $r = $this->ServerConfigurations->getTokenType(/* parameters */);
        $this->assertNull($r);
    }

    /**
     * Tests ServerConfigurations->setTokenType()
     */
    public function testSetTokenType()
    {
        $tokenMock = $this->getMock('OAuth2\TokenType\TokenTypeInterface');
        $this->ServerConfigurations->setTokenType($tokenMock);
        $r = $this->ServerConfigurations->getTokenType();
        $this->assertInstanceOf('OAuth2\TokenType\TokenTypeInterface', $r);
    }

    /**
     * Tests ServerConfigurations->getScopeUtil()
     */
    public function testGetScopeUtil()
    {
        $r = $this->ServerConfigurations->getScopeUtil(/* parameters */);
        $this->assertNull($r);
    }

    /**
     * Tests ServerConfigurations->setScopeUtil()
     */
    public function testSetScopeUtil()
    {
        $stub = $this->getMock('OAuth2\Scope');
        $this->ServerConfigurations->setScopeUtil($stub);
        $r = $this->ServerConfigurations->getScopeUtil();
        $this->assertInstanceOf('OAuth2\Scope', $r);
    }

    /**
     * Tests ServerConfigurations->getClientAssertionType()
     */
    public function testGetClientAssertionType()
    {
        $r = $this->ServerConfigurations->getClientAssertionType(/* parameters */);
        $this->assertNull($r);
    }

    /**
     * Tests ServerConfigurations->setClientAssertionType()
     */
    public function testSetClientAssertionType()
    {
        $stub = $this->getMock('OAuth2\ClientAssertionType\ClientAssertionTypeInterface');
        $this->ServerConfigurations->setClientAssertionType($stub);
        $r = $this->ServerConfigurations->getClientAssertionType();
        $this->assertInstanceOf('OAuth2\ClientAssertionType\ClientAssertionTypeInterface', $r);
    }

    /**
     * Tests ServerConfigurations->getServerClass()
     */
    public function testGetServerClass()
    {
        $r = $this->ServerConfigurations->getServerClass(/* parameters */);
        $this->assertEquals('OAuth2\Server', $r);
    }

    /**
     * Tests ServerConfigurations->setServerClass()
     */
    public function testSetServerClass()
    {
        $this->ServerConfigurations->setServerClass('someClass');
        $r = $this->ServerConfigurations->getServerClass();
        $this->assertEquals('someClass', $r);
    }
}

