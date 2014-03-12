<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\ResponseTypeStrategy\AuthorizationCodeFactory;

/**
 * AuthorizationCodeFactory test case.
 */
class AuthorizationCodeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
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
     * Tests UserCredentialsFactory->createService()
     */
    public function testCreateService()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storage
        $storageCont = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageCont['server1']['authorization_code'] = new Assets\Storage\AuthorizationCodeStorage();

        $classname = 'OAuth2\ResponseType\AuthorizationCode';
        $options = array('storage' => 'authorization_code');
        $r = $this->AuthorizationCodeFactory->createService($mainSm);
        $r = $r($classname, $options, 'server1');
        $this->assertInstanceOf('OAuth2\ResponseType\AuthorizationCodeInterface', $r);
    }

    /**
     * Tests UserCredentialsFactory->createService()
     * @expectedException OAuth2Provider\Exception\InvalidServerException
     */
    public function testCreateServiceReturnsException()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storage
        $storageCont = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageCont['server1']['authorization_code'] = null;

        $classname = 'OAuth2\ResponseType\AuthorizationCode';
        $options = array('storage' => 'authorization_code');
        $r = $this->AuthorizationCodeFactory->createService($mainSm);
        $r = $r($classname, $options, 'server1');
        $this->assertInstanceOf('OAuth2\ResponseType\AuthorizationCodeInterface', $r);
    }
}

