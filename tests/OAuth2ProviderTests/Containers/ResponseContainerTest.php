<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Containers\ResponseContainer;

/**
 * ResponseContainer test case.
 */
class ResponseContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResponseContainer
     */
    private $ResponseContainer;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ResponseContainer = new ResponseContainer(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ResponseContainer = null;
        parent::tearDown();
    }

    /**
     * Tests ResponseContainer->getServerContentsFromKey()
     * @expectedException OAuth2Provider\Exception\ErrorException
     */
    public function testGetServerContentsFromKey()
    {
        $this->ResponseContainer->getServerContentsFromKey('server1', 'key1');
    }

    /**
     * Tests ResponseContainer->isExistingServerContentInKey()
     */
    public function testIsExistingServerContentInKey()
    {
        $r = $this->ResponseContainer->isExistingServerContentInKey('server1', 'key1');
        $this->assertFalse($r);
    }
}

