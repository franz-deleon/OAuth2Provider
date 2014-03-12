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
     * Tests StorageContainer->getServerStorages()
     */
    public function testGetServerContent()
    {
        $expected = array(
            'storage1' => 'ss1',
            'storage2' => 'ss2',
        );

        $this->StorageContainer['server1']['storage1'] = 'ss1';
        $this->StorageContainer['server1']['storage2'] = 'ss2';

        $r = $this->StorageContainer->getServerContents('server1');
        $this->assertSame($expected, $r);
    }

    /**
     * Tests StorageContainer->getServerStorages()
     */
    public function testGetServerContentReturnEmptyArray()
    {
        $r = $this->StorageContainer->getServerContents('server1');
        $this->assertInternalType('array', $r);
        $this->assertEmpty($r);
    }

    /**
     * Tests StorageContainer->getServerStorageInKey()
     */
    public function testGetServerStorageInKey()
    {
        $this->StorageContainer['server1']['storage1'] = 'ss1';
        $this->StorageContainer['server1']['storage2'] = 'ss2';

        $r = $this->StorageContainer->getServerContentsFromKey('server1', 'storage1');
        $this->assertEquals('ss1', $r);

        $r = $this->StorageContainer->getServerContentsFromKey('server1', 'storage2');
        $this->assertEquals('ss2', $r);
    }

    /**
     * Tests StorageContainer->getServerStorageNotInKey()
     */
    public function testGetServerStorageInKeyReturnsEmptyArray()
    {
        $this->StorageContainer['server1']['storage1'] = 'ss1';

        $r = $this->StorageContainer->getServerContentsFromKey('server1', 'storage4');
        $this->assertInternalType('array', $r);
        $this->assertEmpty($r);
    }

    /**
     * Tests StorageContainer->isExistingServerContentInKey()
     */
    public function testisExistingServerContentInKey()
    {
        $this->StorageContainer['server1']['storage1'] = 'ss1';
        $this->StorageContainer['server2']['storage2'] = 'ss2';

        $r = $this->StorageContainer->isExistingServerContentInKey('server1', 'storage1');
        $this->assertTrue($r);
    }

    /**
     * Tests StorageContainer->isExistingServerContentInKey()
     */
    public function testisExistingServerContentInKeyReturnsFalse()
    {
        $this->StorageContainer['server1']['storage1'] = 'ss1';
        $this->StorageContainer['server2']['storage2'] = 'ss2';

        $r = $this->StorageContainer->isExistingServerContentInKey('server1', 'storage2');
        $this->assertFalse($r);
    }
}

