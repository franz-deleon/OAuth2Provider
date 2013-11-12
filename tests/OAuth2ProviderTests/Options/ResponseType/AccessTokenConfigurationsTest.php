<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Options\ResponseType\AccessTokenConfigurations;

/**
 * AccessTokenConfigurations test case.
 */
class AccessTokenConfigurationsTest extends \PHPUnit_Framework_TestCase
{
    /**
	 * @var AccessTokenConfigurations
	 */
    private $AccessTokenConfigurations;
    /**
	 * Prepares the environment before running a test.
	 */
    protected function setUp()
    {
        parent::setUp();
        $this->AccessTokenConfigurations = new AccessTokenConfigurations(/* parameters */);
    }
    /**
	 * Cleans up the environment after running a test.
	 */
    protected function tearDown()
    {
        $this->AccessTokenConfigurations = null;
        parent::tearDown();
    }
    /**
	 * Constructs the test case.
	 */
    public function __construct()
    {
    }

    /**
	 * Tests AccessTokenConfigurations->getTokenStorage()
	 */
    public function testGetTokenStorage()
    {
        $r = $this->AccessTokenConfigurations->getTokenStorage(/* parameters */);
        $this->assertNull($r);
    }

    /**
	 * Tests AccessTokenConfigurations->setTokenStorage()
	 */
    public function testSetTokenStorage()
    {

        $s = $this->AccessTokenConfigurations->setTokenStorage('access_token');
        $this->assertSame($this->AccessTokenConfigurations, $s);

        $r = $this->AccessTokenConfigurations->getTokenStorage();
        $this->assertEquals('access_token', $r);
    }

    /**
	 * Tests AccessTokenConfigurations->getRefreshStorage()
	 */
    public function testGetRefreshStorage()
    {
        $r = $this->AccessTokenConfigurations->getRefreshStorage(/* parameters */);
        $this->assertNull($r);
    }

    /**
	 * Tests AccessTokenConfigurations->setRefreshStorage()
	 */
    public function testSetRefreshStorage()
    {
        $s = $this->AccessTokenConfigurations->setRefreshStorage('refresh_token');
        $this->assertSame($this->AccessTokenConfigurations, $s);

        $r = $this->AccessTokenConfigurations->getRefreshStorage();
        $this->assertEquals('refresh_token', $r);
    }

    /**
	 * Tests AccessTokenConfigurations->getConfig()
	 */
    public function testGetConfig()
    {
        $r = $this->AccessTokenConfigurations->getConfig(/* parameters */);
        $this->assertInternalType('array', $r);
    }

    /**
	 * Tests AccessTokenConfigurations->setConfig()
	 */
    public function testSetConfig()
    {
        $d = array('key' => 'val');
        $s = $this->AccessTokenConfigurations->setConfig($d);
        $this->assertSame($this->AccessTokenConfigurations, $s);

        $r = $this->AccessTokenConfigurations->getConfig();
        $this->assertEquals($d, $r);
    }
}

