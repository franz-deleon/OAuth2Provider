<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\AbstractFactory\ServerAbstractFactory;

use Zend\Stdlib\ArrayUtils;

/**
 * ServerAbstractFactory test case.
 */
class ServerAbstractFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ServerAbstractFactory
     */
    private $ServerAbstractFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ServerAbstractFactory = new ServerAbstractFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ServerAbstractFactory = null;
        parent::tearDown();
    }

    /**
     * Tests ServerAbstractFactory->canCreateServiceWithName()
     * @group test1
     */
    public function testCanCreateServiceWithName()
    {
        $serverKey = uniqid();

        $sm = Bootstrap::getServiceManager(true)->setAllowOverride(true);

        $oauthconfig = array(
            'oauth2provider' => array(
                'servers' => array(
                    $serverKey => array(
                        'storages' => array(
                            'user_credentials' => new Assets\StorageUserCredentials(),
                        ),
                        'grant_types' => array(
                            'user_credentials'
                        ),
                        'server_class' => 'OAuth2ProviderTests\Assets\Foo',
                    ),
                ),
            ),
        );

        $sm->setService('Config', $oauthconfig);

        $r = $this->ServerAbstractFactory->canCreateServiceWithName($sm, null, "oauth2provider.server.{$serverKey}");
        $this->assertTrue($r);
    }

    /**
     * Tests ServerAbstractFactory->canCreateServiceWithName()
     * @group test2
     * @expectedException OAuth2Provider\Exception\InvalidServerException
     */
    public function testCanCreateServiceWithNameReturnException()
    {
        $config = array(
            'myconfig' => array(),
        );

        $configMock = $this->getMock('stdClass', array('getServers'));
        $configMock->expects($this->once())
            ->method('getServers')
            ->will($this->returnValue($config));

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $mainSm->setService('OAuth2Provider/Options/Configuration', $configMock);

        $r = $this->ServerAbstractFactory->canCreateServiceWithName($mainSm, null, 'oauth2provider.server.notexist');
        $this->assertTrue($r);
    }

    /**
     * Tests ServerAbstractFactory->canCreateServiceWithName()
     * @group test3
     */
    public function testCanCreateServiceWithNameReturnFalseOnRegularRequest()
    {
        $mainSm = Bootstrap::getServiceManager();

        $r = $this->ServerAbstractFactory->canCreateServiceWithName($mainSm, null, 'unmatched');
        $this->assertFalse($r);
    }

    /**
     * Tests ServerAbstractFactory->canCreateServiceWithName()
     * @group test4
     */
    public function testCanCreateServiceWithNameReturnFalseOnMismatchedReges()
    {
        $mainSm = Bootstrap::getServiceManager();

        $r = $this->ServerAbstractFactory->canCreateServiceWithName($mainSm, null, 'oauth2provider.server.noMatch&here');
        $this->assertFalse($r);
    }

    /**
     * Tests ServerAbstractFactory->createServiceWithName()
     * @group test5
     */
    public function testCreateServiceWithName()
    {
        $serverKey = uniqid();

        $sm = Bootstrap::getServiceManager(true)->setAllowOverride(true);

        $oauthconfig = array(
            'oauth2provider' => array(
                'servers' => array(
                    $serverKey => array(
                        'storages' => array(
                            'user_credentials' => new Assets\StorageUserCredentials(),
                        ),
                        'grant_types' => array(
                            'user_credentials'
                        ),
                    ),
                ),
            ),
        );

        $sm->setService('Config', $oauthconfig);

        // initialize
        $this->ServerAbstractFactory->canCreateServiceWithName($sm, '', "oauth2provider.server.{$serverKey}");

        $r = $this->ServerAbstractFactory->createServiceWithName($sm, '', "oauth2provider.server.{$serverKey}");
        $this->assertInstanceOf('OAuth2Provider\Server', $r);
    }

    /**
     * Tests ServerAbstractFactory->createServiceWithName()
     * @group test6
     */
    public function testCreateServiceWithNameWillReturnOriginalServer()
    {
        $serverKey = uniqid();

        $sm = Bootstrap::getServiceManager(true)->setAllowOverride(true);

        $oauthconfig = array(
            'oauth2provider' => array(
                'servers' => array(
                    $serverKey => array(
                        'storages' => array(
                            'user_credentials' => new Assets\StorageUserCredentials(),
                        ),
                        'grant_types' => array(
                            'user_credentials'
                        ),
                        'server_class' => 'OAuth2ProviderTests\Assets\Foo',
                    ),
                ),
            ),
        );

        $sm->setService('Config', $oauthconfig);

        // initialize
        $this->ServerAbstractFactory->canCreateServiceWithName($sm, '', "oauth2provider.server.{$serverKey}");

        $r = $this->ServerAbstractFactory->createServiceWithName($sm, '', "oauth2provider.server.{$serverKey}");
        $this->assertInstanceOf('OAuth2\Server', $r);
    }

    /**
     * Tests ServerAbstractFactory->createServiceWithName()
     * @group test7
     */
    public function testCreateServiceWithNameWillMatchServerWithVersion()
    {
        $serverKey = uniqid();

        $sm = Bootstrap::getServiceManager(true, true)->setAllowOverride(true);

        // mock the route match
        $routeMatch = new \Zend\Mvc\Router\RouteMatch(array('version' => 'v2'));
        $sm->get('Application')->getMvcEvent()->setRouteMatch($routeMatch);

        $oauthconfig = array(
            'oauth2provider' => array(
                'servers' => array(
                    $serverKey => array(
                        'storages' => array(
                            'user_credentials' => new Assets\StorageUserCredentials(),
                        ),
                        'grant_types' => array(
                            'user_credentials'
                        ),
                        'server_class' => 'OAuth2ProviderTests\Assets\Foo',
                        'version' => 'v2',
                    ),
                ),
            ),
        );

        $sm->setService('Config', $oauthconfig);

        // initialize
        $this->ServerAbstractFactory->canCreateServiceWithName($sm, '', "oauth2provider.server.{$serverKey}");

        $r = $this->ServerAbstractFactory->createServiceWithName($sm, '', "oauth2provider.server.{$serverKey}");
        $this->assertInstanceOf('OAuth2\Server', $r);
    }

    /**
     * Tests ServerAbstractFactory->createServiceWithName()
     * @group test8
     */
    public function testCreateServiceWithNameWillReturnServerWithMultipleVersion()
    {
        $serverKey = uniqid();

        $sm = Bootstrap::getServiceManager(true, true)->setAllowOverride(true);

        // mock the route match
        $routeMatch = new \Zend\Mvc\Router\RouteMatch(array('version' => 'v2'));
        $sm->get('Application')->getMvcEvent()->setRouteMatch($routeMatch);

        $oauthconfig = array(
            'oauth2provider' => array(
                'servers' => array(
                    $serverKey => array(
                        array(
                            'storages' => array(
                                'user_credentials' => new Assets\StorageUserCredentials(),
                            ),
                            'grant_types' => array(
                                'user_credentials'
                            ),
                            'server_class' => 'OAuth2ProviderTests\Assets\Foo',
                            'version' => 'v1',
                        ),
                        array(
                            'storages' => array(
                                'user_credentials' => new Assets\StorageUserCredentials(),
                            ),
                            'grant_types' => array(
                                'user_credentials'
                            ),
                            'server_class' => 'OAuth2ProviderTests\Assets\Foo',
                            'version' => 'v2',
                        ),
                    ),
                ),
            ),
        );

        $sm->setService('Config', $oauthconfig);

        // initialize
        $this->ServerAbstractFactory->canCreateServiceWithName($sm, '', "oauth2provider.server.{$serverKey}");

        $r = $this->ServerAbstractFactory->createServiceWithName($sm, '', "oauth2provider.server.{$serverKey}");
        $this->assertInstanceOf('OAuth2\Server', $r);
    }

    /**
     * Tests ServerAbstractFactory->createServiceWithName()
     * @group test9
     */
    public function testCreateServiceWithNameWillMatchServerWithMainVersion()
    {
        $serverKey = uniqid();

        $sm = Bootstrap::getServiceManager(true)->setAllowOverride(true);

        $oauthconfig = array(
            'oauth2provider' => array(
                'servers' => array(
                    $serverKey => array(
                        'storages' => array(
                            'user_credentials' => new Assets\StorageUserCredentials(),
                        ),
                        'grant_types' => array(
                            'user_credentials'
                        ),
                        'server_class' => 'OAuth2ProviderTests\Assets\Foo',
                        'version' => 'v2',
                    ),
                ),
                'main_server'  => $serverKey,
                'main_version' => 'v2',
            ),
        );

        $sm->setService('Config', $oauthconfig);

        // initialize
        $this->ServerAbstractFactory->canCreateServiceWithName($sm, '', "oauth2provider.server.{$serverKey}");

        $r = $this->ServerAbstractFactory->createServiceWithName($sm, '', "oauth2provider.server.{$serverKey}");
        $this->assertInstanceOf('OAuth2\Server', $r);
    }
}
