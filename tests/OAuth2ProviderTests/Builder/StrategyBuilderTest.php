<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Builder\StrategyBuilder;

/**
 * GrantTypeFactory test case.
 */
class StrategyBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Tests new StrategyBuilder->__construct()
     * @group test1a
     */
    public function testConstruct()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder(array(), 'serverkey1', array('strategies'), array('concereteclasses'), $container, $interface);
        $this->assertInternalType('object', $builder);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test1b
     */
    public function testInitStrategyFeatureIsPHPObject()
    {
        $storage = new \OAuth2\GrantType\UserCredentials(new Assets\StorageUserCredentials());
        $strategiesConfig = array(
            $storage,
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $subjects  = $strategiesConfig;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertSame(array('user_credentials' => $storage), $r);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test2
     */
    public function testInitStrategyFeatureIsPHPObjectWithUserCredentialAsParent()
    {
        $storage = new Assets\GrantTypeWithParentUserCredentials(new Assets\StorageUserCredentials());
        $strategiesConfig = array(
            $storage,
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $subjects  = $strategiesConfig;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertSame(array('user_credentials' => $storage), $r);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test2b
     */
    public function testInitStrategyFeatureIsPHPObjectWithCustomUserCredentials()
    {
        $storage = new Assets\GrantTypeCustomUserCredentials();
        $strategiesConfig = array(
            $storage,
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $subjects  = $strategiesConfig;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertSame(array('user_credentials' => $storage), $r);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test3
     */
    public function testInitStrategyFeatureIsAServiceManagerElement()
    {
        $storage = new Assets\GrantTypeWithParentUserCredentials(new Assets\StorageUserCredentials());
        $config = array(
            'name' => 'namespace_user_credentials'
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $mainSm->setService('namespace_user_credentials', $storage);

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertSame(array('user_credentials' => $storage), $r);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test4
     */
    public function testInitStrategyFeatureIsAServiceManagerElementUsingConfigAsArrayAndDirectNameAsSMElement()
    {
        $storage = new Assets\GrantTypeWithParentUserCredentials(new Assets\StorageUserCredentials());
        $config = array(
            array(
                'name' => 'user_credentials_x1'
            )
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $mainSm->setService('user_credentials_x1', $storage);

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertSame(array('user_credentials' => $storage), $r);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test5
     */
    public function testInitStrategyFeatureWithStorageAsDirectKey()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $config = array(
            array(
                'name' => 'OAuth2\GrantType\UserCredentials',
                'options' => array(
                    'storage' => 'user_credentials'
                )
            )
        );

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test6
     */
    public function testInitStrategyFeatureWithStorageAsGrantTypeKey()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $config = array(
            'user_credentials' => array(
                'name' => 'OAuth2\GrantType\UserCredentials',
            )
        );

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test5b
     */
    public function testInitStrategyFeatureWithFeatureNameAsAvailableStrategyKey()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server2']['user_credentials'] = new Assets\StorageUserCredentials();

        $config = array(
            'user_credentials',
        );

        $subjects  = $config;
        $serverKey = 'server2';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test6b
     */
    public function testInitStrategyFeatureWithParentAsConcreteGrantTypeAndNotInsideArray()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $config = array(
            'OAuth2ProviderTests\Assets\GrantTypeWithParentUserCredentials',
        );

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test7
     */
    public function testInitStrategyFeatureWithParentAsConcreteGrantType()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $config = array(
            array(
                'name' => 'OAuth2ProviderTests\Assets\GrantTypeWithParentUserCredentials',
                'options' => array(
                    'storage' => 'user_credentials'
                )
            )
        );

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test7a
     */
    public function testInitStrategyFeatureWithParentAsConcreteGrantTypeAndDirectArrayUse()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $config = array(
            array(
                'OAuth2ProviderTests\Assets\GrantTypeWithParentUserCredentials',
            )
        );

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test7aa
     */
    public function testInitStrategyFeatureWithParentAsConcreteGrantTypeAndKeyasExtendedConcrete()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $config = array(
            'user_credentials' => 'OAuth2ProviderTests\Assets\GrantTypeWithParentUserCredentials',
        );

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test7ab
     */
    public function testInitStrategyFeatureWithNameAsAliasedKeyAndDirectArrayUse()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $config = array(
            array(
                'user_credentials',
                'options' => array(),
            )
        );

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test7ba
     */
    public function testInitStrategyFeatureWithParentAsSMAware()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $config = array(
            array(
                'name' => 'OAuth2ProviderTests\Assets\CustomUserCredentialsSMAware',
                'options' => array(
                    'storage' => 'user_credentials'
                )
            )
        );

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test7bb
     */
    public function testInitStrategyFeatureWithParentAsSLAware()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $config = array(
            array(
                'name' => 'OAuth2ProviderTests\Assets\CustomUserCredentialsSLAware',
                'options' => array(
                    'storage' => 'user_credentials'
                )
            )
        );

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test7b
     */
    public function testInitStrategyFeatureWithParentAsKeyAndOptions()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $config = array(
            'user_credentials' => array(
                'options' => array(),
            )
        );

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test7ba
     */
    public function testInitStrategyFeatureWithParentAsKeyAndNameAndOptions()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $config = array(
            'user_credentials' => array(
                'name' => 'user_credentials',
                'options' => array(),
            )
        );

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r['user_credentials']);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test7c
     */
    public function testInitStrategyFeatureWithEmptyConfigString()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $config = '';

        $subjects  = $config;
        $serverKey = uniqid();
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertEmpty($r);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @group test7d
     */
    public function testInitStrategyFeatureWithEmptyConfigArray()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the storagecontainer
        $storageContainer = $mainSm->get('OAuth2Provider/Containers/StorageContainer');
        $storageContainer['server1']['user_credentials'] = new Assets\StorageUserCredentials();

        $config = array();

        $subjects  = $config;
        $serverKey = uniqid();
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertEmpty($r);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @expectedException OAuth2Provider\Exception\InvalidServerException
     * @group test8
     */
    public function testInitStrategyFeatureReturnsExceptionOnNoClassKey()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $config = array(
            array(
                'options' => array(
                    'storage' => 'user_credentials'
                )
            )
        );

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @expectedException OAuth2Provider\Exception\InvalidClassException
     * @group test9
     */
    public function testInitStrategyFeatureReturnsExceptionOnInvalidStrategy()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $config = array(
            array(
                'name' => 'OAuth2ProviderTests\Nothing',
                'options' => array(
                    'storage' => 'user_credentials',
                ),
            )
        );

        $subjects  = $config;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\GrantType\GrantTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @expectedException OAuth2Provider\Exception\InvalidClassException
     * @group test10
     */
    public function testInitStrategyFeatureReturnsExceptionOnInvalidException()
    {
        $storage = new \OAuth2\GrantType\UserCredentials(new Assets\StorageUserCredentials());
        $strategiesConfig = array(
            $storage,
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $subjects  = $strategiesConfig;
        $serverKey = 'server1';
        $container = $mainSm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $strategies = array('user_credentials' => 'OAuth2Provider/GrantTypeStrategy/UserCredentials');
        $concreteClasses = array('user_credentials'   => 'OAuth2\GrantType\UserCredentials');
        $interface = 'OAuth2\ResponseType\ResponseTypeInterface';
        $builder = new StrategyBuilder($subjects, $serverKey, $strategies, $concreteClasses, $container, $interface);

        $r = $builder->initStrategyFeature($mainSm);
        $this->assertSame(array('user_credentials' => $storage), $r);
    }
}

