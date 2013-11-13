<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\AbstractFactory\GrantTypeAbstractFactory;

/**
 * GrantTypeAbstractFactory test case.
 */
class GrantTypeAbstractFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var GrantTypeAbstractFactory
     */
    private $GrantTypeAbstractFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        // TODO Auto-generated GrantTypeAbstractFactoryTest::setUp()

        $this->GrantTypeAbstractFactory = new GrantTypeAbstractFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated GrantTypeAbstractFactoryTest::tearDown()
        $this->GrantTypeAbstractFactory = null;

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
     * Tests GrantTypeAbstractFactory->canCreateServiceWithName()
     * @group test1
     */
    public function testCanCreateServiceWithName()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the container
        $grantTypeContainer = $sm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $grantTypeContainer['server1']['user_credentials'] = new Assets\GrantTypeCustomUserCredentials();

        $r = $this->GrantTypeAbstractFactory->canCreateServiceWithName($sm, '', 'oauth2provider.server.server1.granttype.user_credentials');
        $this->assertTrue($r);
    }

    /**
     * Tests GrantTypeAbstractFactory->canCreateServiceWithName()
     * Remeber that the grant type will only get created through server initializations
     * @group test2
     */
    public function testCanCreateServiceWithNameWithNoServerInitialization()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $serverConfig = array(
            'server1' => array(
                'storages' => array(
                    'user_credentials' => new Assets\StorageUserCredentials(),
                ),
                'grant_types' => array(
                    array(
                        'name' => 'OAuth2\GrantType\UserCredentials',
                        'params' => array(
                            'storage' => 'user_credentials',
                        ),
                    ),
                ),
            ),
        );

        $configMock = $this->getMock('stdClass', array('getServers'));
        $configMock->expects($this->any())
            ->method('getServers')
            ->will($this->returnValue($serverConfig));

        $sm->setService('OAuth2Provider/Options/Configuration', $configMock);

        $r = $this->GrantTypeAbstractFactory->canCreateServiceWithName($sm, '', 'oauth2provider.server.server1.granttype.user_credentials');
        $this->assertTrue($r);
    }

    /**
     * Tests GrantTypeAbstractFactory->canCreateServiceWithName()
     * @group test3
     */
    public function testCanCreateServiceWithNameWithMainAsServerKey()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $serverConfig = array(
            'default' => array(
                'storages' => array(
                    'user_credentials' => new Assets\StorageUserCredentials(),
                ),
                'grant_types' => array(
                    array(
                        'name' => 'OAuth2\GrantType\UserCredentials',
                        'params' => array(
                            'storage' => 'user_credentials',
                        ),
                    ),
                ),
            ),
        );

        $configMock = $this->getMock('stdClass', array('getServers', 'getMainServer'));
        $configMock->expects($this->any())
            ->method('getServers')
            ->will($this->returnValue($serverConfig));
        $configMock->expects($this->any())
            ->method('getMainServer')
            ->will($this->returnValue('default'));

        $sm->setService('OAuth2Provider/Options/Configuration', $configMock);

        $r = $this->GrantTypeAbstractFactory->canCreateServiceWithName($sm, '', 'oauth2provider.server.main.granttype.user_credentials');
        $this->assertTrue($r);
    }

    /**
     * Tests GrantTypeAbstractFactory->createServiceWithName()
     * @group test4
     */
    public function testCreateServiceWithName()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $serverConfig = array(
            'default' => array(
                'storages' => array(
                    'user_credentials' => new Assets\StorageUserCredentials(),
                ),
                'grant_types' => array(
                    array(
                        'name' => 'OAuth2\GrantType\UserCredentials',
                        'params' => array(
                            'storage' => 'user_credentials',
                        ),
                    ),
                ),
            ),
        );

        $configMock = $this->getMock('stdClass', array('getServers', 'getMainServer'));
        $configMock->expects($this->any())
            ->method('getServers')
            ->will($this->returnValue($serverConfig));
        $configMock->expects($this->any())
            ->method('getMainServer')
            ->will($this->returnValue('default'));

        $sm->setService('OAuth2Provider/Options/Configuration', $configMock);

        $this->GrantTypeAbstractFactory->canCreateServiceWithName($sm, '', 'oauth2provider.server.main.granttype.user_credentials');

        $r = $this->GrantTypeAbstractFactory->createServiceWithName($sm, '', '');
        $this->assertInstanceOf('OAuth2\GrantType\UserCredentials', $r);
    }
}

