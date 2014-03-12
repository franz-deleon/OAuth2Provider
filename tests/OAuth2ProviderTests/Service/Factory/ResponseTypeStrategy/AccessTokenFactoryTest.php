<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\ResponseTypeStrategy\AccessTokenFactory;

/**
 * AccessTokenFactory test case.
 */
class AccessTokenFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AccessTokenFactory
     */
    private $AccessTokenFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        // TODO Auto-generated AccessTokenFactoryTest::setUp()
        $this->AccessTokenFactory = new AccessTokenFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated AccessTokenFactoryTest::tearDown()
        $this->AccessTokenFactory = null;
        parent::tearDown();
    }

    /**
     * Tests AccessTokenFactory->createService()
     */
    public function testCreateService()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storage
        $storageCont = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageCont['server1']['access_token'] = new Assets\Storage\AccessTokenStorage();
        $storageCont['server1']['refresh_token'] = new Assets\Storage\RefreshTokenStorage();

        $classname = 'OAuth2\ResponseType\AccessToken';
        $options = array('token_storage' => '', 'refresh_storage' => '');
        $r = $this->AccessTokenFactory->createService($mainSm);
        $r = $r($classname, $options, 'server1');
        $this->assertInstanceOf('OAuth2\ResponseType\AccessTokenInterface', $r);
    }

    /**
     * Tests AccessTokenFactory->createService()
     */
    public function testCreateServiceDoesNotHaveOptionalRefreshTokenStorage()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storage
        $storageCont = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageCont['server1']['access_token'] = new Assets\Storage\AccessTokenStorage();
        $storageCont['server1']['refresh_token'] = null;

        $classname = 'OAuth2\ResponseType\AccessToken';
        $options = array('token_storage' => '', 'refresh_storage' => '');
        $r = $this->AccessTokenFactory->createService($mainSm);
        $r = $r($classname, $options, 'server1');
        $this->assertInstanceOf('OAuth2\ResponseType\AccessTokenInterface', $r);
    }

    /**
     * Tests AccessTokenFactory->createService()
     * @expectedException OAuth2Provider\Exception\InvalidServerException
     */
    public function testCreateServiceReturnsException()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storage
        $storageCont = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageCont['server1']['access_token'] = null;

        $classname = 'OAuth2\ResponseType\AccessToken';
        $options = array('token_storage' => '', 'refresh_storage' => '');
        $r = $this->AccessTokenFactory->createService($mainSm);
        $r($classname, $options, 'server1');
    }


}

