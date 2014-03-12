<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\ScopeStrategy\ScopeFactory;

/**
 * ScopeFactory test case.
 */
class ScopeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var ScopeFactory
     */
    private $ScopeFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ScopeFactory = new ScopeFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ScopeFactory = null;
        parent::tearDown();
    }

    /**
     * Tests ScopeFactory->createService()
     * @group test1
     */
    public function testCreateService()
    {
        $serverKey = uniqid();
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $storage = $sm->get('OAuth2Provider/Containers/StorageContainer');
        $storage[$serverKey]['scope'] = new Assets\Storage\ScopeStorage();

        $f = $this->ScopeFactory->createService($sm);

        $options = array(
            'use_defined_scope_storage' => true,
        );

        $r = $f('OAuth2\Scope', $options, $serverKey);
        $this->assertInstanceOf('OAuth2\Storage\ScopeInterface', $r);
    }

    public function testCreateServiceUsesUserDefinedScope()
    {
        $serverKey = uniqid();
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $sm->setService('scope/storage', new Assets\Storage\ScopeStorage());
        $f = $this->ScopeFactory->createService($sm);

        $options = array(
            'use_defined_scope_storage' => true,
            'storage' => 'scope/storage',
        );

        $r = $f('OAuth2\Scope', $options, $serverKey);
        $this->assertInstanceOf('OAuth2\Storage\ScopeInterface', $r);
    }

    public function testCreateServiceIsManualDefined()
    {
        $serverKey = uniqid();
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $f = $this->ScopeFactory->createService($sm);

        $options = array(
            'default_scope' => 'basic',
            'client_supported_scopes' => array('basic', 'read', 'write', 'delete'),
            'client_default_scopes' => array('basic'),
            'supported_scopes' => array('basic', 'read', 'write', 'delete')
        );

        $r = $f('OAuth2\Scope', $options, $serverKey);
        $this->assertInstanceOf('OAuth2\Storage\ScopeInterface', $r);
    }

    /**
     * @expectedException OAuth2Provider\Exception\InvalidClassException
     */
    public function testCreateServiceReturnsException()
    {
        $serverKey = uniqid();
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $storage = $sm->get('OAuth2Provider/Containers/StorageContainer');
        $storage[$serverKey]['scope'] = new Assets\Storage\AccessTokenStorage();

        $f = $this->ScopeFactory->createService($sm);

        $options = array(
            'use_defined_scope_storage' => true,
        );

        $r = $f('OAuth2\Scope', $options, $serverKey);
    }
}

