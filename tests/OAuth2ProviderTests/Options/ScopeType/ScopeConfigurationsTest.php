<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Options\ScopeType\ScopeConfigurations;

/**
 * ScopeConfigurations test case.
 */
class ScopeConfigurationsTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var ScopeConfigurations
     */
    private $ScopeConfigurations;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ScopeConfigurations = new ScopeConfigurations(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ScopeConfigurations = null;
        parent::tearDown();
    }

    /**
     * Tests ScopeConfigurations->getDefaultScope()
     */
    public function testGetDefaultScope()
    {
        $r = $this->ScopeConfigurations->getDefaultScope(/* parameters */);
        $this->assertNull($r);
    }

    /**
     * Tests ScopeConfigurations->setDefaultScope()
     */
    public function testSetDefaultScope()
    {
        $s = $this->ScopeConfigurations->setDefaultScope('default_scope');
        $this->assertSame($this->ScopeConfigurations, $s);

        $r = $this->ScopeConfigurations->getDefaultScope();
        $this->assertEquals('default_scope', $r);
    }

    /**
     * Tests ScopeConfigurations->getClientSupportedScopes()
     */
    public function testGetClientSupportedScopes()
    {
        $r = $this->ScopeConfigurations->getClientSupportedScopes(/* parameters */);
        $this->assertEmpty($r);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests ScopeConfigurations->setClientSupportedScopes()
     */
    public function testSetClientSupportedScopes()
    {
        $scopes = array('basic');
        $s = $this->ScopeConfigurations->setClientSupportedScopes($scopes);
        $this->assertSame($this->ScopeConfigurations, $s);

        $r = $this->ScopeConfigurations->getClientSupportedScopes();
        $this->assertSame($scopes, $r);
    }

    /**
     * Tests ScopeConfigurations->getClientDefaultScopes()
     */
    public function testGetClientDefaultScopes()
    {
        $r = $this->ScopeConfigurations->getClientDefaultScopes();
        $this->assertEmpty($r);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests ScopeConfigurations->setClientDefaultScopes()
     */
    public function testSetClientDefaultScopes()
    {
        $data = array('basic', 'get');
        $s = $this->ScopeConfigurations->setClientDefaultScopes($data);
        $this->assertSame($this->ScopeConfigurations, $s);

        $r = $this->ScopeConfigurations->getClientDefaultScopes();
        $this->assertSame($data, $r);
    }

    /**
     * Tests ScopeConfigurations->getSupportedScopes()
     */
    public function testGetSupportedScopes()
    {
        $r = $this->ScopeConfigurations->getSupportedScopes(/* parameters */);
        $this->assertEmpty($r);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests ScopeConfigurations->setSupportedScopes()
     */
    public function testSetSupportedScopes()
    {
        $d = array('basic', 'get');
        $s = $this->ScopeConfigurations->setSupportedScopes($d);
        $this->assertSame($this->ScopeConfigurations, $s);

        $r = $this->ScopeConfigurations->getSupportedScopes();
        $this->assertSame($d, $r);
    }

    /**
     * Tests ScopeConfigurations->getUseDefinedScopeStorage()
     */
    public function testGetUseDefinedScopeStorage()
    {
        $r = $this->ScopeConfigurations->getUseDefinedScopeStorage(/* parameters */);
        $this->assertTrue($r);
    }

    /**
     * Tests ScopeConfigurations->setUseDefinedScopeStorage()
     */
    public function testSetUseDefinedScopeStorage()
    {
        $s = $this->ScopeConfigurations->setUseDefinedScopeStorage(false);

        $r = $this->ScopeConfigurations->getUseDefinedScopeStorage();
        $this->assertFalse($r);
    }
}

