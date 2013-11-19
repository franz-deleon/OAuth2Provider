<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Containers\ScopeTypeContainer;

/**
 * ScopeTypeContainer test case.
 */
class ScopeTypeContainerTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var ScopeTypeContainer
     */
    private $ScopeTypeContainer;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ScopeTypeContainer = new ScopeTypeContainer(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ScopeTypeContainer = null;
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }


    /**
     * Tests ConfigContainer->getServerContentsFromKey()
     * @group test1
     * @expectedException OAuth2Provider\Exception\ErrorException
     */
    public function testGetServerContentsFromKey()
    {
        $this->ScopeTypeContainer->getServerContentsFromKey('server1', 'key');
    }

    /**
     * Tests ConfigContainer->isExistingServerContentInKey()
     * @group test2
     */
    public function testIsExistingServerContentInKey()
    {
        $r = $this->ScopeTypeContainer->isExistingServerContentInKey('server1', 'key');
        $this->assertFalse($r);
    }
}

