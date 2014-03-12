<?php
namespace OAuth2ProviderTests;

use OAuth2ProviderTests\Bootstrap;

use OAuth2Provider\Service\Factory\ServerFeature\ClientAssertionTypeFactory;

/**
 * ClientAssertionTypeFactory test case.
 */
class ClientAssertionTypeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientAssertionTypeFactory
     */
    private $ClientAssertionTypeFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ClientAssertionTypeFactory = new ClientAssertionTypeFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ClientAssertionTypeFactory = null;
        parent::tearDown();
    }

    /**
     * Tests ClientAssertionTypeFactory->createService()
     */
    public function testCreateService()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $serverKey = uniqid();
        $storage = $sm->get('OAuth2Provider/Containers/StorageContainer');
        $storage[$serverKey]['client_credentials'] = new Assets\Storage\ClientCredentialsStorage();

        $strategies = array(
            'name' => 'http_basic',
            'options' => array(
                'configs' => array(
                    'allow_credentials_in_request_body' => false,
                ),
            ),
        );

        $service = $this->ClientAssertionTypeFactory->createService($sm);
        $r = $service($strategies, $serverKey);
        $this->assertInstanceOf('OAuth2\ClientAssertionType\HttpBasic', $r);
    }
}
