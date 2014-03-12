<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\ServerFeature\ConfigFactory;

/**
 * ConfigFactory test case.
 */
class ConfigFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConfigFactory
     */
    private $ConfigFactory;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ConfigFactory = new ConfigFactory(/* parameters */);
    }
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ConfigFactory = null;
        parent::tearDown();
    }

    /**
     * Tests ConfigFactory->createService()
     */
    public function testCreateService()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the container
        $configContainer = $mainSm->get('OAuth2Provider/Containers/ConfigContainer');
        $configContainer['server1'] = $expected = array('key1' => 'val1');

        $config = $this->ConfigFactory->createService($mainSm);
        $r = $config($expected, 'server1');

        $this->assertSame($expected, $r);
    }
}
