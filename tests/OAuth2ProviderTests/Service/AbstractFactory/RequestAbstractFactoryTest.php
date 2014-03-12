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

        $sm->setService("oauth2provider.server.{$serverKey}", new \stdClass());
        $sm->get('OAuth2Provider/Options/Configuration')->setMainServer($serverKey);

        $r = $this->RequestAbstractFactory->canCreateServiceWithName($sm, '', "oauth2provider.server.{$serverKey}.request");
        $this->assertTrue($r);
    }

    /**
     * Tests RequestAbstractFactory->canCreateServiceWithName()
     * @expectedException OAuth2Provider\Exception\ErrorException
     */
    public function testCanCreateServiceWithNameReturnsException()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $serverKey = uniqid();

        $sm->get('OAuth2Provider/Options/Configuration')->setMainServer($serverKey);

        $r = $this->RequestAbstractFactory->canCreateServiceWithName($sm, '', "oauth2provider.server.{$serverKey}.request");
    }

    /**
     * Tests RequestAbstractFactory->canCreateServiceWithName()
     */
    public function testCanCreateServiceReturnsFalseOnMalformedInvalidRequestName()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $serverKey = "*&*";

        $sm->get('OAuth2Provider/Options/Configuration')->setMainServer($serverKey);

        $r = $this->RequestAbstractFactory->canCreateServiceWithName($sm, '', "oauth2provider.server.{$serverKey}.request");
        $this->assertFalse($r);
    }

    /**
     * Tests RequestAbstractFactory->createServiceWithName()
     */
    public function testCreateServiceWithName()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $serverKey = uniqid();

        $sm->setService("oauth2provider.server.{$serverKey}", new \stdClass());
        $sm->get('OAuth2Provider/Options/Configuration')->setMainServer($serverKey);

        // execute
        $this->RequestAbstractFactory->canCreateServiceWithName($sm, '', "oauth2provider.server.{$serverKey}.request");

        $r = $this->RequestAbstractFactory->createServiceWithName($sm, '', "oauth2provider.server.{$serverKey}.request");
        $this->assertInstanceOf('OAuth2\Request', $r);
    }
}

