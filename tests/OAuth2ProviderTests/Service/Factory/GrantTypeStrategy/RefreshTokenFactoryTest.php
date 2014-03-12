<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\GrantTypeStrategy\RefreshTokenFactory;

/**
 * RefreshTokenFactory test case.
 */
class RefreshTokenFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var RefreshTokenFactory
     */
    private $RefreshTokenFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->RefreshTokenFactory = new RefreshTokenFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->RefreshTokenFactory = null;

        parent::tearDown();
    }

    /**
     * Tests RefreshTokenFactory->createService()
     */
    public function testCreateService()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $options = array(
            'refresh_token_storage' => new Assets\Storage\RefreshTokenStorage(),
        );

        $s = $this->RefreshTokenFactory->createService($mainSm);
        $r = $s('OAuth2\GrantType\RefreshToken', $options, 'server3');
        $this->assertInstanceOf('OAuth2\GrantType\GrantTypeInterface', $r);
    }

    /**
     * Tests RefreshTokenFactory->createService()
     * @expectedException OAuth2Provider\Exception\InvalidServerException
     */
    public function testCreateServiceReturnsException()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $options = array(
            'refresh_token_storage' => 'nothing',
        );

        $s = $this->RefreshTokenFactory->createService($mainSm);
        $s('OAuth2\GrantType\RefreshToken', $options, 'server3');
    }
}

