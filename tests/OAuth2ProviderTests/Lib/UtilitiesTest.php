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
        $r = Utilities::createClass('OAuth2ProviderTests\Assets\Foo::bar');
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

    /**
     * Tests Utilities::createClass()
     */
    public function testExtractClassnameFromFQNS()
    {
        $r = Utilities::extractClassnameFromFQNS('OAuth2ProviderTests\Assets\Foo');
        $this->assertEquals('Foo', $r);
    }

/**
     * Tests Utilities::createClass()
     */
    public function testExtractClassnameFromFQNSIsOBject()
    {
        $foo = new \OAuth2ProviderTests\Assets\Foo();
        $r = Utilities::extractClassnameFromFQNS($foo);
        $this->assertEquals('Foo', $r);
    }

    /**
     * Tests Utilities::storageLookup()
     */
    public function testStorageLookupWhereSubjectInExistingContainer()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the container
        $container = $sm->get('OAuth2Provider/Containers/StorageContainer');
        $container['serverKey']['user_credentials'] = new \stdClass();

        $r = Utilities::storageLookup('serverKey', 'user_credentials', $container, $sm, 'user_credentials');
        $this->assertEquals(new \stdClass(), $r);
    }

    /**
     * Tests Utilities::storageLookup()
     */
    public function testStorageLookupWhereSubjectInDefaultIdentifier()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);

        // seed the container
        $container = $sm->get('OAuth2Provider/Containers/StorageContainer');
        $container['serverKey']['user_credentials'] = new \stdClass();

        $r = Utilities::storageLookup('serverKey', null, $container, $sm, 'user_credentials');
        $this->assertEquals(new \stdClass(), $r);
    }

    /**
     * Tests Utilities::storageLookup()
     */
    public function testStorageLookupWhereSubjectIsSMElement()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $sm->setService('UserCredentials', new \stdClass());

        // seed the container
        $container = $sm->get('OAuth2Provider/Containers/StorageContainer');
        $container['serverKey']['access_token'] = new \stdClass();

        $r = Utilities::storageLookup('serverKey', 'UserCredentials', $container, $sm);
        $this->assertEquals(new \stdClass(), $r);
    }

    /**
     * Tests Utilities::storageLookup()
     */
    public function testStorageLookupWhereSubjectIsAnObject()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $sm->setService('UserCredentials', new \stdClass());

        // seed the container
        $container = $sm->get('OAuth2Provider/Containers/StorageContainer');
        $container['serverKey']['access_token'] = new \stdClass();

        $r = Utilities::storageLookup('serverKey', new \stdClass(), $container, $sm);
        $this->assertEquals(new \stdClass(), $r);
    }

    /**
     * Tests Utilities::storageLookup()
     */
    public function testStorageLookupReturnsDefault()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $sm->setService('UserCredentials', new \stdClass());

        // seed the container
        $container = $sm->get('OAuth2Provider/Containers/StorageContainer');
        $container['serverKey']['access_token'] = new \stdClass();

        $r = Utilities::storageLookup('serverKey', 'jwt_bearer', $container, $sm, 'identifier', 'XxDEFAULTxX');
        $this->assertEquals('XxDEFAULTxX', $r);
    }

    /**
     * Tests TokenTypeFactory->singleStrategyOptionExtractor()
     * @group test1
     */
    public function testSingleStrategyOptionExtractorWithConfigAsDirectName()
    {
        $config = 'bearer';

        $r = Utilities::singleStrategyOptionExtractor($config);
        $this->assertEquals(array('bearer'), $r);
    }

    /**
     * @group test2
     */
    public function testSingleStrategyOptionExtractorWithConfigAsDirectInsideArray()
    {
        $config = array('bearer');

        $r = Utilities::singleStrategyOptionExtractor($config);
        $this->assertEquals(array('bearer'), $r);
    }

    /**
     * @group test3
     */
    public function testSingleStrategyOptionExtractorWithConfigAsDirectWithNameInsideArray()
    {
        $config = array(
            'name' => 'bearer',
        );

        $r = Utilities::singleStrategyOptionExtractor($config);
        $this->assertSame(array('name' => 'bearer'), $r);
    }

    /**
     * Tests TokenTypeFactory->createService()
     * @group test4
     */
    public function testSingleStrategyOptionExtractorWithConfigAsArrayWithNameAndOptions()
    {
        $config = array(
            array(
                'name' => 'bearer',
                'options' => array(
                    'configs' => array(
                        'token_bearer_header_name' => 'franz',
                    ),
                ),
            ),
        );

        $r = Utilities::singleStrategyOptionExtractor($config);
        $this->assertSame($config, $r);
    }

    /**
     * @group test5
     */
    public function testSingleStrategyOptionExtractorWithConfigAsDirectWithNameAndOptions()
    {
        $config = array(
            'name' => 'bearer',
            'options' => array(
                'configs' => array(
                    'token_bearer_header_name' => 'franz',
                ),
            ),
        );

        $r = Utilities::singleStrategyOptionExtractor($config);
        $this->assertSame(array($config), $r);
    }

    /**
     * @group test6
     */
    public function testSingleStrategyOptionExtractorWithConfigAsWithNameArrayInsideArray()
    {
        $config = array(
            array(
                'name' => 'bearer'
            ),
        );

        $r = Utilities::singleStrategyOptionExtractor($config);
        $this->assertSame($config, $r);
    }

    /**
     * Tests TokenTypeFactory->createService()
     * @group test7
     */
    public function testSingleStrategyOptionExtractorWithConfigAsArrayInsideArrayWithMultipleInputs()
    {
        $config = array(
            array(
                'name' => 'bearer'
            ),
            array(
                'name' => 'bearer'
            ),
        );

        $r = Utilities::singleStrategyOptionExtractor($config);

        $expected  = array(
            array(
                'name' => 'bearer'
            )
        );

        $this->assertSame($expected, $r);
    }

    /**
     * @group test8
     */
    public function testSingleStrategyOptionWithConfigIsNull()
    {
        $config = null;
        $r = Utilities::singleStrategyOptionExtractor($config);
        $this->assertSame(array(null), $r);
    }

    /**
     * Tests TokenTypeFactory->createService()
     * @group test8
     */
    public function testSingleStrategyOptionWithConfigIsEmpty()
    {
        $config = array();

        $r = Utilities::singleStrategyOptionExtractor($config);
        $this->assertSame(array(), $r);
    }
}
