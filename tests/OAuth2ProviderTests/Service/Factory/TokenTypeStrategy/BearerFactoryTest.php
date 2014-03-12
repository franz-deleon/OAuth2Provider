<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\TokenTypeStrategy\BearerFactory;

/**
 * BearerFactory test case.
 */
class BearerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BearerFactory
     */
    private $BearerFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->BearerFactory = new BearerFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->BearerFactory = null;
        parent::tearDown();
    }

    /**
     * Tests BearerFactory->createService()
     */
    public function testCreateService()
    {
        $mainSm = Bootstrap::getServiceManager();

        $config = array(
            'configs' => array(
                'token_param_name' => 'test',
            ),
        );

        $r = $this->BearerFactory->createService($mainSm);
        $r = $r('OAuth2\TokenType\Bearer', $config, 'server2');
        $this->assertInstanceOf('OAuth2\TokenType\TokenTypeInterface', $r);
    }

    /**
     * Tests BearerFactory->createService()
     * @expectedException OAuth2Provider\Exception\InvalidServerException
     */
    public function testCreateServiceReturnsException()
    {
        $mainSm = Bootstrap::getServiceManager();

        $config = array(
            'configs' => array(
                'Xtoken_param_nameX' => 'test',
            ),
        );

        $r = $this->BearerFactory->createService($mainSm);
        $r('OAuth2\TokenType\Bearer', $config, 'server2');
    }
}

