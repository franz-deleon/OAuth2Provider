<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\GrantTypeStrategy\UserCredentialsFactory;

/**
 * UserCredentialsFactory test case.
 */
class UserCredentialsFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
	 * @var UserCredentialsFactory
	 */
    private $UserCredentialsFactory;

    /**
	 * Prepares the environment before running a test.
	 */
    protected function setUp()
    {
        parent::setUp();
        $this->UserCredentialsFactory = new UserCredentialsFactory(/* parameters */);
    }

    /**
	 * Cleans up the environment after running a test.
	 */
    protected function tearDown()
    {
        $this->UserCredentialsFactory = null;
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
        $storageCont['server1']['user_credentials'] = new Assets\Storage\UserCredentialsStorage();

        $classname = 'OAuth2ProviderTests\Assets\GrantTypeCustomUserCredentials';
        $options = array('storage' => 'user_credentials');
        $r = $this->UserCredentialsFactory->createService($mainSm);
        $r = $r($classname, $options, 'server1');
        $this->assertInstanceOf('OAuth2\GrantType\GrantTypeInterface', $r);
    }

    /**
     * @expectedException OAuth2Provider\Exception\InvalidServerException
     */
    public function testCreateServiceReturnsException()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storage
        $storageCont = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageCont['server1']['user_credentials'] = '';

        $classname = 'OAuth2ProviderTests\Assets\GrantTypeCustomUserCredentials';
        $options = array('storage' => 'user_credentials');
        $r = $this->UserCredentialsFactory->createService($mainSm);
        $r($classname, $options, 'server1');
    }
}

