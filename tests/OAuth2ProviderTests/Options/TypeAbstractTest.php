<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Options\TypeAbstract;

/**
 * TypeAbstract test case.
 */
class TypeAbstractTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var TypeAbstract
     */
    private $TypeAbstract;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        // TODO Auto-generated TypeAbstractTest::setUp()

        $this->TypeAbstract = new TypeAbstract(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated TypeAbstractTest::tearDown()
        $this->TypeAbstract = null;

        parent::tearDown();
    }

    /**
     * Tests TypeAbstract->getStorage()
     */
    public function testGetStorage()
    {
        $r = $this->TypeAbstract->getStorage(/* parameters */);
        $this->assertNull($r);
    }

    /**
     * Tests TypeAbstract->setStorage()
     */
    public function testSetStorage()
    {
        $s = $this->TypeAbstract->setStorage('storage');
        $this->assertSame($this->TypeAbstract, $s);

        $r = $this->TypeAbstract->getStorage();
        $this->assertEquals('storage', $r);
    }
}

