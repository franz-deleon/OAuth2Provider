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
     * Tests Configuration->getDefaultController()
     */
    public function testGetDefaultController()
    {
        $r = $this->Configuration->getDefaultController(/* parameters */);
        $this->assertNull($r);
    }

    /**
     * Tests Configuration->setDefaultController()
     */
    public function testSetDefaultController()
    {
        $r = $this->Configuration->setDefaultController('con');
        $this->assertSame($this->Configuration, $r);
    }

    /**
     * Tests Configuration->setController()
     */
    public function testSetDefaultControllerReturnsExpected()
    {
        $this->Configuration->setDefaultController('con');
        $r = $this->Configuration->getDefaultController();
        $this->assertEquals('con', $r);
    }

    /**
     * Tests Configuration->getMainVersion()
     */
    public function testGetMainVersion()
    {
        $r = $this->Configuration->getMainVersion();
        $this->assertNull($r);
    }

    /**
     * Tests Configuration->setMainVersion()
     */
    public function testSetMainVersion()
    {
        $r = $this->Configuration->setMainVersion('v1');
        $this->assertSame($this->Configuration, $r);

        $r = $this->Configuration->getMainVersion();
        $this->assertEquals('v1', $r);
    }
}

