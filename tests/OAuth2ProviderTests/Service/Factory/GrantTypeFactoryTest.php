<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\GrantTypeFactory;

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
    public function testCreateServiceGrantTypeIsPHPObjectWithUserCredentialParent()
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
        //$this->assertSame(array('user_credentials' => $storage), $r);
    }
}

