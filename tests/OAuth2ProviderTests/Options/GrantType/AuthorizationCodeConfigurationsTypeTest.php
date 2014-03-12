<?php
namespace OAuth2ProviderTests\Options\GrantType;

use OAuth2Provider\Options\GrantType\AuthorizationCodeConfigurations;

/**
 * AuthorizationCodeConfigurations test case.
 */
class AuthorizationCodeConfigurationsTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
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
        $r = $this->AuthorizationCodeConfigurations->setAuthorizationCodeStorage('authorization_code');
        $this->assertSame($this->AuthorizationCodeConfigurations, $r);

        $r = $this->AuthorizationCodeConfigurations->getAuthorizationCodeStorage();
        $this->assertEquals('authorization_code', $r);
    }
}
