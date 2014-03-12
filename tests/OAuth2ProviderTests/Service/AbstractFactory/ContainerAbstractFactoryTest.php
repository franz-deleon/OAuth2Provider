<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\AbstractFactory\ContainerAbstractFactory;

/**
 * ContainerAbstractFactory test case.
 */
class ContainerAbstractFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var ContainerAbstractFactory
     */
    private $ContainerAbstractFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ContainerAbstractFactory = new ContainerAbstractFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ContainerAbstractFactory = null;

        parent::tearDown();
    }

    /**
     * Tests ContainerAbstractFactory->canCreateServiceWithName()
     */
    public function testCanCreateServiceWithNameReturnsFalseOnNonMatches()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $r = $this->ContainerAbstractFactory->canCreateServiceWithName($sm, '', 'non-ouath');

        $this->assertFalse($r);
    }

    /**
     * Tests ContainerAbstractFactory->canCreateServiceWithName()
     */
    public function testCanCreateServiceWithNameReturnsFalseOnInvalidReges()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $r = $this->ContainerAbstractFactory->canCreateServiceWithName($sm, '', 'oauth2provider.server.---');

        $this->assertFalse($r);
    }

    /**
     * Tests ContainerAbstractFactory->canCreateServiceWithName()
     * @group test2
     */
    public function testCanCreateServiceWithKeyAsMainAndHasNoSMInstance()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $serverKey = uniqid();

        $container = $sm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $container[$serverKey]['grant_type'] = new \stdClass();

        $sm->setService('oauth2provider.server.default', new \stdClass());

        $r = $this->ContainerAbstractFactory->canCreateServiceWithName($sm, '', 'oauth2provider.server.main.grant_type');

        $this->assertTrue($r);
    }

    /**
     * Tests ContainerAbstractFactory->canCreateServiceWithName()
     * @group test3
     */
    public function testCanCreateServiceWithContainerKeyAndHasNoSMInstance()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $serverKey = uniqid();

        $sm->setService("oauth2provider.server.{$serverKey}", new \stdClass());

        $container = $sm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $container[$serverKey]['user_credentials'] = new \stdClass();

        $r = $this->ContainerAbstractFactory->canCreateServiceWithName(
            $sm, '', "oauth2provider.server.{$serverKey}.grant_type.user_credentials"
        );

        $this->assertTrue($r);
    }

    /**
     * Tests ContainerAbstractFactory->canCreateServiceWithName()
     * @group test4
     */
    public function testCanCreateServiceWithContainerKeyAndHasSMInstance()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $serverKey = uniqid();

        $sm->get('OAuth2Provider/Options/Configuration')->setServers(array(
            $serverKey => array(),
        ));

        $container = $sm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $container[$serverKey]['user_credentials'] = new Assets\GrantTypeCustomUserCredentials();

        $r = $this->ContainerAbstractFactory->canCreateServiceWithName(
            $sm, '', "oauth2provider.server.{$serverKey}.grant_type.user_credentials"
        );

        $this->assertTrue($r);
    }

    /**
     * Tests ContainerAbstractFactory->canCreateServiceWithName()
     * @group test5
     */
    public function testCanCreateServiceWithContainerKeyHasNoSMInstanceAndInvalidContainerKey()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $serverKey = uniqid();

        $sm->setService("oauth2provider.server.{$serverKey}", new \stdClass());

        $container = $sm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $container[$serverKey]['user_credentials'] = new \stdClass();

        $r = $this->ContainerAbstractFactory->canCreateServiceWithName(
            $sm, '', "oauth2provider.server.{$serverKey}.grant_type.zzz"
        );

        $this->assertFalse($r);
    }

    /**
     * Tests ContainerAbstractFactory->canCreateServiceWithName()
     * @group test6
     */
    public function testCanCreateServiceWithInvalidContainerKey()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $serverKey = uniqid();

        $sm->setService("oauth2provider.server.{$serverKey}", new \stdClass());

        $r = $this->ContainerAbstractFactory->canCreateServiceWithName(
            $sm, '', "oauth2provider.server.{$serverKey}.invalidcontainer"
        );

        $this->assertFalse($r);
    }

    /**
     * Tests ContainerAbstractFactory->createServiceWithName()
     * @group test7
     */
    public function testCreateServiceWithName()
    {
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $serverKey = uniqid();

        $sm->setService("oauth2provider.server.{$serverKey}", new \stdClass());

        $container = $sm->get('OAuth2Provider/Containers/GrantTypeContainer');
        $container[$serverKey]['user_credentials'] = new \stdClass();

        $this->ContainerAbstractFactory->canCreateServiceWithName(
            $sm, '', "oauth2provider.server.{$serverKey}.grant_type.user_credentials"
        );


        $r = $this->ContainerAbstractFactory->createServiceWithName($sm, '', '');
        $this->assertInstanceOf('stdClass', $r);
    }
}

