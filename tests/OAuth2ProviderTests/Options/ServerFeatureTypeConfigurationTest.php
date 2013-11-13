<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Options\ServerFeatureTypeConfiguration;

/**
 * ServerFeatureTypeConfiguration test case.
 */
class ServerFeatureTypeConfigurationTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var ServerFeatureTypeConfiguration
     */
    private $ServerFeatureTypeConfiguration;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ServerFeatureTypeConfiguration = new ServerFeatureTypeConfiguration(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ServerFeatureTypeConfiguration = null;

        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    /**
     * Tests ServerFeatureTypeConfiguration->getName()
     */
    public function testGetName()
    {
        $r = $this->ServerFeatureTypeConfiguration->getName(/* parameters */);
        $this->assertNull($r);
    }

    /**
     * Tests ServerFeatureTypeConfiguration->setName()
     */
    public function testSetName()
    {
        $s = $this->ServerFeatureTypeConfiguration->setName('user_credentials');
        $this->assertSame($this->ServerFeatureTypeConfiguration, $s);

        $r = $this->ServerFeatureTypeConfiguration->getName();
        $this->assertEquals('user_credentials', $r);
    }

    /**
     * Tests ServerFeatureTypeConfiguration->getParams()
     */
    public function testGetParams()
    {
        $r = $this->ServerFeatureTypeConfiguration->getParams(/* parameters */);
        $this->assertInternalType('array', $r);
    }

    /**
     * Tests ServerFeatureTypeConfiguration->setParams()
     */
    public function testSetParams()
    {
        $s = $this->ServerFeatureTypeConfiguration->setParams(array('server1'));
        $this->assertSame($this->ServerFeatureTypeConfiguration, $s);

        $r = $this->ServerFeatureTypeConfiguration->getParams();
        $this->assertEquals(array('server1'), $r);
    }
}

