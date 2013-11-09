<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Lib\Utilities;

/**
 * Utilities test case.
 */
class UtilitiesTest extends \PHPUnit_Framework_TestCase
{
    /**
	 * @var Utilities
	 */
    private $Utilities;
    /**
	 * Prepares the environment before running a test.
	 */
    protected function setUp()
    {
        parent::setUp();
        // TODO Auto-generated UtilitiesTest::setUp()
        $this->Utilities = new Utilities(/* parameters */);
    }
    /**
	 * Cleans up the environment after running a test.
	 */
    protected function tearDown()
    {
        // TODO Auto-generated UtilitiesTest::tearDown()
        $this->Utilities = null;
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
	 * Tests Utilities::createClass()
	 */
    public function testCreateClassReturnsSmObject()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $sm->setService('someObj', new \stdClass());

        $r = Utilities::createClass('someObj', $sm);
        $this->assertInstanceOf('stdClass', $r);
    }

    /**
	 * Tests Utilities::createClass()
	 */
    public function testCreateClassReturnsObjectFromFQNS()
    {
        $r = Utilities::createClass('\stdClass');
        $this->assertInstanceOf('stdClass', $r);
    }

    /**
	 * Tests Utilities::createClass()
	 */
    public function testCreateClassReturnsObjectFromCallable()
    {
        $r = Utilities::createClass('OAuth2ProviderTests\Assets\foo::bar');
        $this->assertInstanceOf('stdClass', $r);
    }

    /**
	 * Tests Utilities::createClass()
	 */
    public function testCreateClassReturnsObjectFromObject()
    {
        $r = Utilities::createClass(new \stdClass);
        $this->assertInstanceOf('stdClass', $r);
    }

    /**
	 * Tests Utilities::createClass()
	 * @expectedException OAuth2Provider\Exception\ClassNotExistException
	 */
    public function testCreateClassReturnsException()
    {
        $r = Utilities::createClass('franz');
    }
}

