<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\ServerFeature\GrantTypeFactory;

/**
 * GrantTypeFactory test case.
 */
class GrantTypeFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var GrantTypeFactory
     */
    private $GrantTypeFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        // TODO Auto-generated GrantTypeFactoryTest::setUp()

        $this->GrantTypeFactory = new GrantTypeFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated GrantTypeFactoryTest::tearDown()
        $this->GrantTypeFactory = null;

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
     * Tests GrantTypeFactory->createService()
     * @group test1
     */
    public function testCreateServiceGrantTypeIsPHPObject()
    {
        $storage = new \OAuth2\GrantType\UserCredentials(new Assets\StorageUserCredentials());
        $grantTypeConfig = array(
            $storage,
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $factory = $this->GrantTypeFactory->createService($mainSm);
        $r = $factory($grantTypeConfig, 'server1');
        $this->assertSame(array('user_credentials' => $storage), $r);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test2
     */
    public function testCreateServiceGrantTypeIsPHPObjectWithUserCredentialAsParent()
    {
        $storage = new Assets\GrantTypeWithParentUserCredentials(new Assets\StorageUserCredentials());
        $grantTypeConfig = array(
            $storage,
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $factory = $this->GrantTypeFactory->createService($mainSm);
        $r = $factory($grantTypeConfig, 'server1');
        $this->assertSame(array('user_credentials' => $storage), $r);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test2b
     */
    public function testCreateServiceGrantTypeIsPHPObjectWithCustomUserCredentials()
    {
        $storage = new Assets\GrantTypeCustomUserCredentials();
        $grantTypeConfig = array(
            $storage,
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $factory = $this->GrantTypeFactory->createService($mainSm);
        $r = $factory($grantTypeConfig, 'server1');
        $this->assertSame(array('user_credentials' => $storage), $r);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test3
     */
    public function testCreateServiceGrantTypeIsAServiceManagerElement()
    {
        $storage = new Assets\GrantTypeWithParentUserCredentials(new Assets\StorageUserCredentials());
        $grantTypeConfig = array(
            'class' => 'user/credentials'
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $mainSm->setService('user/credentials', $storage);

        $factory = $this->GrantTypeFactory->createService($mainSm);
        $r = $factory($grantTypeConfig, 'server1');
        $this->assertSame(array('user_credentials' => $storage), $r);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test4
     */
    public function testCreateServiceGrantTypeIsAServiceManagerElementUsingConfigAsArray()
    {
        $storage = new Assets\GrantTypeWithParentUserCredentials(new Assets\StorageUserCredentials());
        $grantTypeConfig = array(
            array(
                'class' => 'user/credentials'
            )
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $mainSm->setService('user/credentials', $storage);

        $factory = $this->GrantTypeFactory->createService($mainSm);
        $r = $factory($grantTypeConfig, 'server1');
        $this->assertSame(array('user_credentials' => $storage), $r);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test5
     */
    public function testCreateServiceGrantTypeWithStorageAsDirectKey()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $grantTypeConfig = array(
            array(
                'class' => 'OAuth2\GrantType\UserCredentials',
                'params' => array(
                    'storage' => 'user_credentials'
                )
            )
        );

        $factory = $this->GrantTypeFactory->createService($mainSm);
        $r = $factory($grantTypeConfig, 'server1');
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test6
     */
    public function testCreateServiceGrantTypeWithStorageAsGrantTypeKey()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $grantTypeConfig = array(
            'user_credentials' => array(
                'class' => 'OAuth2\GrantType\UserCredentials',
            )
        );

        $factory = $this->GrantTypeFactory->createService($mainSm);
        $r = $factory($grantTypeConfig, 'server1');
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test7
     */
    public function testCreateServiceGrantTypeWithParentAsConcreteGrantType()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $grantTypeConfig = array(
            array(
                'class' => 'OAuth2ProviderTests\Assets\GrantTypeWithParentUserCredentials',
                'params' => array(
                    'storage' => 'user_credentials'
                )
            )
        );

        $factory = $this->GrantTypeFactory->createService($mainSm);
        $r = $factory($grantTypeConfig, 'server1');
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @expectedException OAuth2Provider\Exception\InvalidServerException
     * @group test8
     */
    public function testCreateServiceGrantTypeReturnsExceptionOnNoClassKey()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $grantTypeConfig = array(
            array(
                'params' => array(
                    'storage' => 'user_credentials'
                )
            )
        );

        $factory = $this->GrantTypeFactory->createService($mainSm);
        $factory($grantTypeConfig, 'server1');
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @expectedException OAuth2Provider\Exception\InvalidClassException
     * @group test10
     */
    public function testCreateServiceGrantTypeReturnsExceptionOnInvalidStrategy()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $grantTypeConfig = array(
            array(
                'class' => 'OAuth2ProviderTests\Nothing',
                'params' => array(
                    'storage' => 'user_credentials',
                ),
            )
        );

        $factory = $this->GrantTypeFactory->createService($mainSm);
        $factory($grantTypeConfig, 'server1');
    }
}

