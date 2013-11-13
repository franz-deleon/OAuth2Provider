<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Options\ResponseType\AuthorizationCodeConfigurations;

/**
 * AuthorizationCodeConfigurations test case.
 */
class AuthorizationCodeConfigurationsTest extends \PHPUnit_Framework_TestCase
{
    /**
	 * @var AuthorizationCodeConfigurations
	 */
    private $AuthorizationCodeConfigurations;

    /**
	 * Prepares the environment before running a test.
	 */
    protected function setUp()
    {
        parent::setUp();
        $this->AuthorizationCodeConfigurations = new AuthorizationCodeConfigurations(/* parameters */);
    }

    /**
	 * Cleans up the environment after running a test.
	 */
    protected function tearDown()
    {
        $this->AuthorizationCodeConfigurations = null;
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
	 * Tests AuthorizationCodeConfigurations->getAuthorizationCodeStorage()
	 */
    public function testGetAuthorizationCodeStorage()
    {
        $r = $this->AuthorizationCodeConfigurations->getAuthorizationCodeStorage(/* parameters */);
        $this->assertNull($r);
    }

    /**
	 * Tests AuthorizationCodeConfigurations->setAuthorizationCodeStorage()
	 */
    public function testSetAuthorizationCodeStorage()
    {
        $s = $this->AuthorizationCodeConfigurations->setAuthorizationCodeStorage('authorization_code');
        $this->assertSame($this->AuthorizationCodeConfigurations, $s);

        $r = $this->AuthorizationCodeConfigurations->getAuthorizationCodeStorage();
        $this->assertEquals('authorization_code', $r);
    }

    /**
	 * Tests AuthorizationCodeConfigurations->getConfig()
	 */
    public function testGetConfig()
    {
        $r = $this->AuthorizationCodeConfigurations->getConfig(/* parameters */);
        $this->assertInternalType('array', $r);
    }

    /**
	 * Tests AuthorizationCodeConfigurations->setConfig()
	 */
    public function testSetConfig()
    {
        $s = $this->AuthorizationCodeConfigurations->setConfig(array('config'));
        $this->assertSame($this->AuthorizationCodeConfigurations, $s);

        $r = $this->AuthorizationCodeConfigurations->getConfig();
        $this->assertSame(array('config'), $r);
    }
}

