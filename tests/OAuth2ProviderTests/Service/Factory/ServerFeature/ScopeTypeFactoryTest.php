<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\ServerFeature\ScopeTypeFactory;

/**
 * ScopeTypeFactory test case.
 */
class ScopeTypeFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var ScopeTypeFactory
     */
    private $ScopeTypeFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ScopeTypeFactory = new ScopeTypeFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ScopeTypeFactory = null;

        parent::tearDown();
    }

    /**
     * Tests ScopeTypeFactory->createService()
     */
    public function testCreateService()
    {
        $serverKey = uniqid();
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $storage = $sm->get('OAuth2Provider/Containers/StorageContainer');
        $storage[$serverKey]['scope'] = new Assets\Storage\ScopeStorage();

        $options = array(
            'name' => 'scope'
        );

        $f = $this->ScopeTypeFactory->createService($sm);
        $r = $f($options, $serverKey);

        $this->assertInstanceOf('OAuth2\Scope', $r);
    }

    /**
     * Tests ScopeTypeFactory->createService()
     */
    public function testCreateServiceWhereOptionInsideArray()
    {
        $serverKey = uniqid();
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $storage = $sm->get('OAuth2Provider/Containers/StorageContainer');
        $storage[$serverKey]['scope'] = new Assets\Storage\ScopeStorage();

        $options = array(
            array(
                'name' => 'scope'
            ),
        );

        $f = $this->ScopeTypeFactory->createService($sm);
        $r = $f($options, $serverKey);

        $this->assertInstanceOf('OAuth2\Scope', $r);
    }

    /**
     * Tests ScopeTypeFactory->createService()
     */
    public function testCreateServiceUsingManualScope()
    {
        $serverKey = uniqid();
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $options = array(
            'name' => 'scope',
            'options' => array(
                'default_scope' => 'basic',
                'client_supported_scopes' => array('basic', 'read', 'write', 'delete'),
                'client_default_scopes' => array('basic'),
                'supported_scopes' => array('basic', 'read', 'write', 'delete')
            )
        );

        $f = $this->ScopeTypeFactory->createService($sm);
        $r = $f($options, $serverKey);

        $this->assertInstanceOf('OAuth2\Scope', $r);
    }

    /**
     * Tests ScopeTypeFactory->createService()
     */
    public function testCreateServiceReturnsNull()
    {
        $serverKey = uniqid();
        $sm = Bootstrap::getServiceManager()->setAllowOverride(true);

        $options = array();

        $f = $this->ScopeTypeFactory->createService($sm);
        $r = $f($options, $serverKey);

        $this->assertNull($r);
    }
}

