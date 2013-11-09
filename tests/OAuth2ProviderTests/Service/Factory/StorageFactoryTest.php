<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\StorageFactory;

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
	 * Constructs the test case.
	 */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }

    /**
	 * Tests GrantTypeFactory->createService()
	 */
    public function testCreateService()
    {
        $mainSm = Bootstrap::getServiceManager();

        $storageFactory = $this->storageFactory->createService($mainSm);
        $r = $storageFactory(new \stdClass(), 'user_credentials', 'default');
        $this->assertInstanceOf('stdClass', $r);
    }

    /**
	 * Tests GrantTypeFactory->createService()
	 * @expectedException OAuth2Provider\Exception\InvalidConfigException
	 */
    public function testCreateServiceReturnsException()
    {
        $mainSm = Bootstrap::getServiceManager();

        $storageFactory = $this->storageFactory->createService($mainSm);
        $r = $storageFactory(new \stdClass(), 'user_xxx', 'default');
    }
}

