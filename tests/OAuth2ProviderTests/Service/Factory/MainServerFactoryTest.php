<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\MainServerFactory;

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

        // TODO Auto-generated MainServerFactoryTest::setUp()

        $this->MainServerFactory = new MainServerFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated MainServerFactoryTest::tearDown()
        $this->MainServerFactory = null;

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
     * Tests MainServerFactory->createService()
     */
    public function testCreateService()
    {
        $config = array(
            'oauth2provider' => array(
                'servers' => array(
                    'default' => array(
                        'storages' => array(
                            'user_credentials' => new Assets\StorageUserCredentials(),
                        ),
                        'grant_types' => array(
                            array(
                                'class' => 'OAuth2\GrantType\UserCredentials',
                                'params' => array(
                                    'storage' => 'user_credentials',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $mainSm->setService('Config', $config);

        //$r = $this->MainServerFactory->createService($mainSm);
        $this->markTestIncomplete("createServiceWithName test not implemented");
    }
}

