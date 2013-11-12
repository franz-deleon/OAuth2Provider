<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Options\Configuration;

/**
 * Configuration test case.
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Configuration
     */
    private $Configuration;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        // TODO Auto-generated ConfigurationTest::setUp()

        $this->Configuration = new Configuration(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated ConfigurationTest::tearDown()
        $this->Configuration = null;

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
     * Tests Configuration->getMainServer()
     * @group test1
     */
    public function testGetMainServerDefault()
    {
        $r = $this->Configuration->getMainServer(/* parameters */);
        $this->assertEquals('default', $r);
    }

    /**
     * Tests Configuration->setMainServer()
     * @group test2
     */
    public function testSetMainServer()
    {
        $r = $this->Configuration->setMainServer('server55');
        $this->assertSame($this->Configuration, $r);
    }

    /**
     * Tests Configuration->setMainServerReturnsExpected()
     * @group test3
     */
    public function testSetMainServerReturnsExpected()
    {
        $this->Configuration->setMainServer('server55');
        $r = $this->Configuration->getMainServer();
        $this->assertSame('server55', $r);
    }

    /**
     * Tests Configuration->getServers()
     */
    public function testGetServers()
    {
        $r = $this->Configuration->getServers(/* parameters */);
        $this->assertNull($r);
    }

    /**
     * Tests Configuration->setServers()
     */
    public function testSetServers()
    {
        $r = $this->Configuration->setServers(array('server1' => array()));
        $this->assertSame($this->Configuration, $r);
    }

    /**
     * Tests Configuration->setServers()
     */
    public function testSetServersReturnsExpected()
    {
        $d = array('server1' => array());
        $this->Configuration->setServers($d);
        $r = $this->Configuration->getServers();
        $this->assertEquals($d, $r);
    }

    /**
     * Tests Configuration->getController()
     */
    public function testGetController()
    {
        $r = $this->Configuration->getController(/* parameters */);
        $this->assertNull($r);
    }

    /**
     * Tests Configuration->setController()
     */
    public function testSetController()
    {
        $r = $this->Configuration->setController('con');
        $this->assertSame($this->Configuration, $r);
    }

    /**
     * Tests Configuration->setController()
     */
    public function testSetControllerReturnsExpected()
    {
        $this->Configuration->setController('con');
        $r = $this->Configuration->getController();
        $this->assertEquals('con', $r);
    }
}

