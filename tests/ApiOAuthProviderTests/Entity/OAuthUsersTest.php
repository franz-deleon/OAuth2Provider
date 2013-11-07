<?php
namespace ApiOAuthProviderTests\Entity;

use ApiOAuthProvider\Entity\OAuthUsers;

/**
 * OAuthUsers test case.
 */
class OAuthUsersTest extends \PHPUnit_Framework_TestCase
{
    /**
	 * @var OAuthUsers
	 */
    private $OAuthUsers;
    /**
	 * Prepares the environment before running a test.
	 */
    protected function setUp()
    {
        parent::setUp();
        // TODO Auto-generated OAuthUsersTest::setUp()
        $this->OAuthUsers = new OAuthUsers(/* parameters */);
    }
    /**
	 * Cleans up the environment after running a test.
	 */
    protected function tearDown()
    {
        // TODO Auto-generated OAuthUsersTest::tearDown()
        $this->OAuthUsers = null;
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
	 * Tests OAuthUsers->generatePassword()
	 * @group EncryptPassword
	 */
    public function testEncrpytPassword()
    {
        $r = $this->OAuthUsers->EncryptPassword('franz');
        $this->assertNotNull($r);
    }
}

