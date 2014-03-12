<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\GrantTypeStrategy\ClientCredentialsFactory;

/**
 * ClientCredentialsFactory test case.
 */
class ClientCredentialsFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var ClientCredentialsFactory
     */
    private $ClientCredentialsFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ClientCredentialsFactory = new ClientCredentialsFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ClientCredentialsFactory = null;

        parent::tearDown();
    }

    /**
     * Tests ClientCredentialsFactory->createService()
     */
    public function testCreateService()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $options = array(
            'client_credentials_storage' => new Assets\Storage\ClientCredentialsStorage(),
            'configs' => array(),
        );

        $r = $this->ClientCredentialsFactory->createService($mainSm);
        $r = $r('OAuth2\GrantType\ClientCredentials', $options, 'server3');
        $this->assertInstanceOf('OAuth2\GrantType\ClientCredentials', $r);
    }

    /**
     * Tests ClientCredentialsFactory->createService()
     * @expectedException OAuth2Provider\Exception\InvalidServerException
     */
    public function testCreateServiceReturnsException()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $options = array(
            'client_credentials_storage' => 'nothere',
        );

        $r = $this->ClientCredentialsFactory->createService($mainSm);
        $r('OAuth2\GrantType\ClientCredentials', $options, 'server3');
    }
}

