<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\ControllerFactory;

/**
 * ControllerFactory test case.
 */
class ControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ControllerFactory
     */
    private $ControllerFactory;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        // TODO Auto-generated ControllerFactoryTest::setUp()
        $this->ControllerFactory = new ControllerFactory(/* parameters */);
    }
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated ControllerFactoryTest::tearDown()
        $this->ControllerFactory = null;
        parent::tearDown();
    }

    /**
     * Tests ControllerFactory->createService()
     * @group test1
     */
    public function testCreateServiceWithValidControllerUsesDefaultController()
    {
        $serverKey = uniqid();

        $config = array(
            'oauth2provider' => array(
                'servers' => array(
                    $serverKey => array(),
                ),
                'main_server' => $serverKey,
                'default_controller' => 'OAuth2ProviderTests\Assets\ImplementingController',
            ),
        );

        $mainSm = Bootstrap::getServiceManager(true)->setAllowOverride(true);
        $mainSm->setService('Config', $config);

        $pluginSM = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->setMethods(array('getServiceLocator'))
            ->getMock();
        $pluginSM->expects($this->any())
            ->method('getServiceLocator')
            ->will($this->returnValue($mainSm));

        $r = $this->ControllerFactory->createService($pluginSM);
        $this->assertInstanceOf('OAuth2Provider\Controller\ControllerInterface', $r);
    }

    /**
     * Tests ControllerFactory->createService()
     * @group test2
     */
    public function testCreateServiceWithValidControllerUsesServerSpecificController()
    {
        $serverKey = uniqid();

        $mainSm = Bootstrap::getServiceManager(true)->setAllowOverride(true);

        $config = array(
            'oauth2provider' => array(
                'servers' => array(
                    $serverKey => array(
                        'controller' => 'OAuth2ProviderTests\Assets\ImplementingController'
                    ),
                ),
                'main_server' => $serverKey,
            ),
        );

        $mainSm->setService('Config', $config);

        $pluginSM = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->setMethods(array('getServiceLocator'))
            ->getMock();
        $pluginSM->expects($this->any())
            ->method('getServiceLocator')
            ->will($this->returnValue($mainSm));

        $r = $this->ControllerFactory->createService($pluginSM);
        $this->assertInstanceOf('OAuth2Provider\Controller\ControllerInterface', $r);
    }

    /**
     * Tests ControllerFactory->createService()
     * @group test3
     */
    public function testCreateServiceWithValidControllerUsesServerSpecificControllerOnMultiServers()
    {
        $serverKey = uniqid();

        $mainSm = Bootstrap::getServiceManager(true, true)->setAllowOverride(true);

        $routeMatch = new \Zend\Mvc\Router\RouteMatch(array('version' => 'v2'));
        $mainSm->get('Application')->getMvcEvent()->setRouteMatch($routeMatch);

        $config = array(
            'oauth2provider' => array(
                'servers' => array(
                    $serverKey => array(
                        array(
                            'controller' => 'xxx',
                            'version' => 'v1',
                        ),
                        array(
                            'controller' => 'OAuth2ProviderTests\Assets\ImplementingController',
                            'version' => 'v2',
                        ),
                    ),
                ),
                'main_server'  => $serverKey,
                'main_version' => 'v2',
            ),
        );

        $mainSm->setService('Config', $config);

        $pluginSM = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->setMethods(array('getServiceLocator'))
            ->getMock();
        $pluginSM->expects($this->exactly(2))
            ->method('getServiceLocator')
            ->will($this->returnValue($mainSm));

        $r = $this->ControllerFactory->createService($pluginSM);
        $this->assertInstanceOf('OAuth2Provider\Controller\ControllerInterface', $r);
    }

    /**
     * Tests ControllerFactory->createService()
     * @group test4
     * @expectedException OAuth2Provider\Exception\InvalidConfigException
     */
    public function testCreateServiceReturnsException()
    {
        $serverKey = uniqid();

        $mainSm = Bootstrap::getServiceManager(true)->setAllowOverride(true);

        $config = array(
            'oauth2provider' => array(
                'servers' => array(
                    $serverKey => array(
                        'controller' => 'OAuth2ProviderTests\Assets\RegularController'
                    ),
                ),
                'main_server' => $serverKey,
            ),
        );

        $mainSm->setService('Config', $config);

        $pluginSM = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->setMethods(array('getServiceLocator'))
            ->getMock();
        $pluginSM->expects($this->once())
            ->method('getServiceLocator')
            ->will($this->returnValue($mainSm));

        $r = $this->ControllerFactory->createService($pluginSM);
    }
}

