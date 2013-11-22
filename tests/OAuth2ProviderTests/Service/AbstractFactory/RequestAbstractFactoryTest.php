<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\AbstractFactory\RequestAbstractFactory;

/**
 * RequestAbstractFactory test case.
 */
class RequestAbstractFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var RequestAbstractFactory
     */
    private $RequestAbstractFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->RequestAbstractFactory = new RequestAbstractFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->RequestAbstractFactory = null;

        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    /**
     * Tests RequestAbstractFactory->canCreateServiceWithName()
     */
    public function testCanCreateServiceWithNameReturnsFalseOnMalformedRname()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $r = $this->RequestAbstractFactory->canCreateServiceWithName($sm, '', 'ouath2provide.xxx');
        $this->assertFalse($r);
    }

    /**
     * Tests RequestAbstractFactory->canCreateServiceWithName()
     *
     */
    public function testCanCreateServiceWithNameUsingMainAndExistingSMInstance()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $serverKey = uniqid();

        $sm->get('OAuth2Provider/Options/Configuration')->setMainServer('mainSMxxx');

        $r = $this->RequestAbstractFactory->canCreateServiceWithName($sm, '', "oauth2provider.server.main.request");
        $this->assertTrue($r);
    }

    /**
     * Tests RequestAbstractFactory->createServiceWithName()
     */
    public function testCreateServiceWithName()
    {
        // TODO Auto-generated RequestAbstractFactoryTest->testCreateServiceWithName()
        $this->markTestIncomplete("createServiceWithName test not implemented");

        $this->RequestAbstractFactory->createServiceWithName(/* parameters */);
    }
}

