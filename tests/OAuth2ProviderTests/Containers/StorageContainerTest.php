<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Containers\StorageContainer;

/**
 * StorageContainer test case.
 */
class StorageContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
	 * @var StorageContainer
	 */
    private $StorageContainer;
    /**
	 * Prepares the environment before running a test.
	 */
    protected function setUp()
    {
        parent::setUp();
        // TODO Auto-generated StorageContainerTest::setUp()
        $this->StorageContainer = new StorageContainer(/* parameters */);
    }
    /**
	 * Cleans up the environment after running a test.
	 */
    protected function tearDown()
    {
        // TODO Auto-generated StorageContainerTest::tearDown()
        $this->StorageContainer = null;
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
	 * Tests StorageContainer->getServerStorages()
	 */
    public function testGetServerStorages()
    {
        $expected = array(
            'storage1' => 'ss1',
            'storage2' => 'ss2',
        );

        $this->StorageContainer['server1']['storage1'] = 'ss1';
        $this->StorageContainer['server1']['storage2'] = 'ss2';

        $r = $this->StorageContainer->getServerStorages('server1');
        $this->assertSame($expected, $r);
    }

    /**
	 * Tests StorageContainer->getServerStorageInKey()
	 */
    public function testGetServerStorageInKey()
    {
        $this->StorageContainer['server1']['storage1'] = 'ss1';
        $this->StorageContainer['server1']['storage2'] = 'ss2';

        $r = $this->StorageContainer->getServerStorageInKey('server1', 'storage1');
        $this->assertEquals('ss1', $r);

        $r = $this->StorageContainer->getServerStorageInKey('server1', 'storage2');
        $this->assertEquals('ss2', $r);
    }
}

