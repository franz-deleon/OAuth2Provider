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
     * Tests UserCredentialsConfigurations->getStorage()
     */
    public function testGetUserCredentialsStorage()
    {
        $r = $this->UserCredentialsConfigurations->getUserCredentialsStorage(/* parameters */);
        $this->assertNull($r);
    }

    /**
     * Tests UserCredentialsConfigurations->setStorage()
     */
    public function testSetStorage()
    {
        $r = $this->UserCredentialsConfigurations->setUserCredentialsStorage('user_credentials');
        $this->assertSame($this->UserCredentialsConfigurations, $r);
    }

    /**
     * Tests UserCredentialsConfigurations->setStorage()
     */
    public function testSetStorageReturnsExpected()
    {
        $this->UserCredentialsConfigurations->setUserCredentialsStorage('user_credentials');
        $r = $this->UserCredentialsConfigurations->getUserCredentialsStorage();
        $this->assertEquals('user_credentials', $r);
    }
}

