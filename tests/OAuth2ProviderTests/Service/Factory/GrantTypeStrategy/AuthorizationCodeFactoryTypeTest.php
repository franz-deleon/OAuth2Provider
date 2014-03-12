<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\GrantTypeStrategy\AuthorizationCodeFactory;

/**
 * AuthorizationCodeFactory test case.
 */
class AuthorizationCodeFactoryTypeTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var AuthorizationCodeFactory
     */
    private $AuthorizationCodeFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->AuthorizationCodeFactory = new AuthorizationCodeFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->AuthorizationCodeFactory = null;
        parent::tearDown();
    }

    /**
     * Tests AuthorizationCodeFactory->createService()
     */
    public function testCreateService()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $options = array(
            'authorization_code_storage' => new Assets\Storage\AuthorizationCodeStorage(),
        );

        $r = $this->AuthorizationCodeFactory->createService($mainSm);
        $r = $r('OAuth2\GrantType\AuthorizationCode', $options, 'server4');
        $this->assertInstanceOf('OAuth2\GrantType\AuthorizationCode', $r);
    }

    /**
     * Tests AuthorizationCodeFactory->createService()
     * @expectedException OAuth2Provider\Exception\InvalidServerException
     */
    public function testCreateServiceReturnsException()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $options = array(
            'authorization_code_storage' => 'xxXXxx',
        );

        $r = $this->AuthorizationCodeFactory->createService($mainSm);
        $r = $r('OAuth2\GrantType\AuthorizationCode', $options, 'server4');
    }
}

