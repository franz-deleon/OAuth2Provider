<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\ServerFeature\StorageFactory;

/**
 * GrantTypeFactory test case.
 */
class StorageFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GrantTypeFactory
     */
    private $storageFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        // TODO Auto-generated GrantTypeFactoryTest::setUp()
        $this->storageFactory = new StorageFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated GrantTypeFactoryTest::tearDown()
        $this->storageFactory = null;
        parent::tearDown();
    }

    /**
     * Tests GrantTypeFactory->createService()
     */
    public function testCreateService()
    {
        $storages = array(
            'user_credentials' => new \stdClass(),
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $storageFactory = $this->storageFactory->createService($mainSm);
        $r = $storageFactory($storages, 'server_key');
    }

    /**
     * Tests GrantTypeFactory->createService()
     * @expectedException OAuth2Provider\Exception\InvalidConfigException
     */
    public function testCreateServiceReturnsException()
    {
        $storages = array(
            'not_in_valid' => new \stdClass(),
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $storageFactory = $this->storageFactory->createService($mainSm);
        $r = $storageFactory($storages, 'server_key');
    }
}

