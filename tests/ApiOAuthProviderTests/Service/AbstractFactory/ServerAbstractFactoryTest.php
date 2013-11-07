<?php
namespace ApiOAuthProviderTests;

use ApiOAuthProvider\Service\AbstractFactory\ServerAbstractFactory;

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
        // TODO Auto-generated ServerAbstractFactoryTest::setUp()
        $this->ServerAbstractFactory = new ServerAbstractFactory(/* parameters */);
    }
    /**
	 * Cleans up the environment after running a test.
	 */
    protected function tearDown()
    {
        // TODO Auto-generated ServerAbstractFactoryTest::tearDown()
        $this->ServerAbstractFactory = null;
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
	 * Tests ServerAbstractFactory->canCreateServiceWithName()
	 */
    public function testCanCreateServiceWithName()
    {
        $config = array(
            'myconfig' => array(),
        );

        $configMock = $this->getMock('stdClass', array('getServer'));
        $configMock->expects($this->once())
            ->method('getServer')
            ->will($this->returnValue($config));

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $mainSm->setService('ApiOAuthProvider\Options\Configuration', $configMock);

        $r = $this->ServerAbstractFactory->canCreateServiceWithName($mainSm, null, 'apioauthprovider.server.myconfig');
        $this->assertTrue($r);
    }

    /**
	 * Tests ServerAbstractFactory->canCreateServiceWithName()
	 * @expectedException ApiOAuthProvider\Exception\InvalidServerException
	 */
    public function testCanCreateServiceWithNameReturnException()
    {
        $config = array(
            'myconfig' => array(),
        );

        $configMock = $this->getMock('stdClass', array('getServer'));
        $configMock->expects($this->once())
            ->method('getServer')
            ->will($this->returnValue($config));

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $mainSm->setService('ApiOAuthProvider\Options\Configuration', $configMock);

        $r = $this->ServerAbstractFactory->canCreateServiceWithName($mainSm, null, 'apioauthprovider.server.notexist');
        $this->assertTrue($r);
    }

    /**
	 * Tests ServerAbstractFactory->canCreateServiceWithName()
	 */
    public function testCanCreateServiceWithNameReturnFalseOnRegularRequest()
    {
        $mainSm = Bootstrap::getServiceManager();

        $r = $this->ServerAbstractFactory->canCreateServiceWithName($mainSm, null, 'someserver');
        $this->assertFalse($r);
    }

    /**
	 * Tests ServerAbstractFactory->createServiceWithName()
	 */
    public function testCreateServiceWithName()
    {
        // TODO Auto-generated ServerAbstractFactoryTest->testCreateServiceWithName()
        $this->markTestIncomplete("createServiceWithName test not implemented");
        $this->ServerAbstractFactory->createServiceWithName(/* parameters */);
    }
}

