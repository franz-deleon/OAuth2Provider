<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Containers\ConfigContainer;

/**
 * ConfigContainer test case.
 */
class ConfigContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConfigContainer
     */
    private $ConfigContainer;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ConfigContainer = new ConfigContainer(/* parameters */);
    }
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ConfigContainer = null;
        parent::tearDown();
    }

    /**
     * Tests ConfigContainer->getServerContentsFromKey()
     * @group test1
     * @expectedException OAuth2Provider\Exception\ErrorException
     */
    public function testGetServerContentsFromKey()
    {
        $this->ConfigContainer->getServerContentsFromKey('server1', 'key');
    }

    /**
     * Tests ConfigContainer->isExistingServerContentInKey()
     * @group test2
     */
    public function testIsExistingServerContentInKey()
    {
        $r = $this->ConfigContainer->isExistingServerContentInKey('server1', 'key');
        $this->assertFalse($r);
    }
}

