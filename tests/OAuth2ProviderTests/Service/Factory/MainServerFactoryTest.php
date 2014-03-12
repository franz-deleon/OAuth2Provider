<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\MainServerFactory;

use Zend\Stdlib\ArrayUtils;

/**
 * MainServerFactory test case.
 */
class MainServerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var MainServerFactory
     */
    private $MainServerFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->MainServerFactory = new MainServerFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->MainServerFactory = null;
        parent::tearDown();
    }

    /**
     * Tests MainServerFactory->createService()
     */
    public function testCreateService()
    {
        $oauthconfig = array(
            'oauth2provider' => array(
                'servers' => array(
                    'default' => array(
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

        $mainSm = Bootstrap::getServiceManager(true)->setAllowOverride(true);
        $mainSm->setService('Config', $oauthconfig);

        $r = $this->MainServerFactory->createService($mainSm);
        $this->assertInstanceOf('OAuth2Provider\Server', $r);
    }
}
