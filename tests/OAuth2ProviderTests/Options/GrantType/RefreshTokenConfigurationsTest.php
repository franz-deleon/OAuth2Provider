<?php
namespace OAuth2ProviderTests\Options\GrantType;

use OAuth2Provider\Options\GrantType\RefreshTokenConfigurations;

/**
 * RefreshTokenConfigurations test case.
 */
class RefreshTokenConfigurationsTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var RefreshTokenConfigurations
     */
    private $RefreshTokenConfigurations;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->RefreshTokenConfigurations = new RefreshTokenConfigurations(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->RefreshTokenConfigurations = null;
        parent::tearDown();
    }

    /**
     * Tests RefreshTokenConfigurations->getRefreshTokenStorage()
     */
    public function testGetRefreshTokenStorage()
    {
        $r = $this->RefreshTokenConfigurations->getRefreshTokenStorage(/* parameters */);
        $this->assertNull($r);
    }

    /**
     * Tests RefreshTokenConfigurations->setRefreshTokenStorage()
     */
    public function testSetRefreshTokenStorage()
    {
        $s = $this->RefreshTokenConfigurations->setRefreshTokenStorage('refresh_token');
        $this->assertSame($this->RefreshTokenConfigurations, $s);

        $r = $this->RefreshTokenConfigurations->getRefreshTokenStorage();
        $this->assertEquals('refresh_token', $r);
    }

    /**
     * Tests RefreshTokenConfigurations->getConfigs()
     */
    public function testGetConfigs()
    {
        $r = $this->RefreshTokenConfigurations->getConfigs(/* parameters */);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests RefreshTokenConfigurations->setConfigs()
     */
    public function testSetConfigs()
    {
        $s = $this->RefreshTokenConfigurations->setConfigs(array('refresh_token'));
        $this->assertSame($this->RefreshTokenConfigurations, $s);

        $r = $this->RefreshTokenConfigurations->getConfigs();
        $this->assertSame(array('refresh_token'), $r);
    }
}

