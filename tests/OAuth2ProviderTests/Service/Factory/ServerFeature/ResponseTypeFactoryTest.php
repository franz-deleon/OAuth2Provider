<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\ServerFeature\ResponseTypeFactory;

/**
 * ResponseTypeFactory test case.
 */
class ResponseTypeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResponseTypeFactory
     */
    private $ResponseTypeFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->ResponseTypeFactory = new ResponseTypeFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->ResponseTypeFactory = null;
        parent::tearDown();
    }


    /**
     * Tests ResponseTypeFactory->createService()
     */
    public function testCreateService()
    {
        $storage = new \OAuth2\ResponseType\AccessToken(new Assets\Storage\AccessTokenStorage);
        $strategies = array(
            $storage,
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $r = $this->ResponseTypeFactory->createService($mainSm);
        $this->assertSame(array('token' => $storage), $r($strategies, 'server1'));
    }
}

