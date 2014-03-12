<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Containers\RequestContainer;

/**
 * RequestContainer test case.
 */
class RequestContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RequestContainer
     */
    private $RequestContainer;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->RequestContainer = new RequestContainer(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->RequestContainer = null;
        parent::tearDown();
    }

    /**
     * Tests RequestContainer->getServerContentsFromKey()
     * @expectedException OAuth2Provider\Exception\ErrorException
     */
    public function testGetServerContentsFromKey()
    {
        $this->RequestContainer->getServerContentsFromKey('server1', 'key1');
    }

    /**
     * Tests RequestContainer->isExistingServerContentInKey()
     */
    public function testIsExistingServerContentInKey()
    {
        $r = $this->RequestContainer->isExistingServerContentInKey('server1', 'key1');
        $this->assertFalse($r);
    }
}
