<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Options\GrantType\UserCredentialsConfigurations;

/**
 * UserCredentialsConfigurations test case.
 */
class UserCredentialsConfigurationsTest extends \PHPUnit_Framework_TestCase
{
    /**
	 * @var UserCredentialsConfigurations
	 */
    private $UserCredentialsConfigurations;

    /**
	 * Prepares the environment before running a test.
	 */
    protected function setUp()
    {
        parent::setUp();
        $this->UserCredentialsConfigurations = new UserCredentialsConfigurations(/* parameters */);
    }

    /**
	 * Cleans up the environment after running a test.
	 */
    protected function tearDown()
    {
        $this->UserCredentialsConfigurations = null;
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
	 * Tests UserCredentialsConfigurations->getStorage()
	 */
    public function testGetStorage()
    {
        $r = $this->UserCredentialsConfigurations->getStorage(/* parameters */);
        $this->assertNull($r);
    }

    /**
	 * Tests UserCredentialsConfigurations->setStorage()
	 */
    public function testSetStorage()
    {
        $r = $this->UserCredentialsConfigurations->setStorage('user_credentials');
        $this->assertSame($this->UserCredentialsConfigurations, $r);
    }

    /**
	 * Tests UserCredentialsConfigurations->setStorage()
	 */
    public function testSetStorageReturnsExpected()
    {
        $this->UserCredentialsConfigurations->setStorage('user_credentials');
        $r = $this->UserCredentialsConfigurations->getStorage();
        $this->assertEquals('user_credentials', $r);
    }
}

