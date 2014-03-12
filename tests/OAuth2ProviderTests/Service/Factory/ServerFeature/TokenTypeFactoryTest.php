<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\ServerFeature\TokenTypeFactory;

/**
 * TokenTypeFactory test case.
 */
class TokenTypeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TokenTypeFactory
     */
    private $TokenTypeFactory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->TokenTypeFactory = new TokenTypeFactory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->TokenTypeFactory = null;
        parent::tearDown();
    }

    /**
     * Tests TokenTypeFactory->createService()
     * @group test1
     */
    public function testCreateServiceWithConfigAsDirectName()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $config = 'bearer';

        $ser = $this->TokenTypeFactory->createService($mainSm);
        $r = $ser($config, 'server3');
        $this->assertInstanceOf('OAuth2\TokenType\TokenTypeInterface', $r);
    }

    /**
     * Tests TokenTypeFactory->createService()
     * @group test2
     */
    public function testCreateServiceWithConfigAsDirectInsideArray()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $config = array('bearer');

        $ser = $this->TokenTypeFactory->createService($mainSm);
        $r = $ser($config, 'server3');
        $this->assertInstanceOf('OAuth2\TokenType\TokenTypeInterface', $r);
    }

    /**
     * Tests TokenTypeFactory->createService()
     * @group test3
     */
    public function testCreateServiceWithConfigAsDirectWithNameInsideArray()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $config = array(
            'name' => 'bearer',
        );

        $ser = $this->TokenTypeFactory->createService($mainSm);
        $r = $ser($config, 'server3');
        $this->assertInstanceOf('OAuth2\TokenType\TokenTypeInterface', $r);
    }

    /**
     * Tests TokenTypeFactory->createService()
     * @group test4
     */
    public function testCreateServiceWithConfigAsArrayWithNameAndOptions()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
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

        $ser = $this->TokenTypeFactory->createService($mainSm);
        $r = $ser($config, 'server3');
        $this->assertInstanceOf('OAuth2\TokenType\TokenTypeInterface', $r);
    }

    /**
     * Tests TokenTypeFactory->createService()
     * @group test5
     */
    public function testCreateServiceWithConfigAsDirectWithNameAndOptions()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $config = array(
            'name' => 'bearer',
            'options' => array(
                'configs' => array(
                    'token_bearer_header_name' => 'franz',
                ),
            ),
        );

        $ser = $this->TokenTypeFactory->createService($mainSm);
        $r = $ser($config, 'server3');
        $this->assertInstanceOf('OAuth2\TokenType\TokenTypeInterface', $r);
    }

    /**
     * Tests TokenTypeFactory->createService()
     * @group test6
     */
    public function testCreateServiceWithConfigAsWithNameArrayInsideArray()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $config = array(
            array(
                'name' => 'bearer'
            ),
        );

        $ser = $this->TokenTypeFactory->createService($mainSm);
        $r = $ser($config, 'server3');
        $this->assertInstanceOf('OAuth2\TokenType\TokenTypeInterface', $r);
    }

    /**
     * Tests TokenTypeFactory->createService()
     * @group test7
     */
    public function testCreateServiceWithConfigAsWithNameArrayInsideArrayWithMultipleInputs()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $config = array(
            array(
                'name' => 'bearer'
            ),
            array(
                'name' => 'bearer'
            ),
        );

        $ser = $this->TokenTypeFactory->createService($mainSm);
        $r = $ser($config, 'server3');
        $this->assertInstanceOf('OAuth2\TokenType\TokenTypeInterface', $r);
    }

    /**
     * Tests TokenTypeFactory->createService()
     * @group test8
     */
    public function testCreateServiceWithConfigIsNull()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $config = null;

        $ser = $this->TokenTypeFactory->createService($mainSm);
        $r = $ser($config, 'server3');
        $this->assertNull($r);
    }

    /**
     * Tests TokenTypeFactory->createService()
     * @group test8
     */
    public function testCreateServiceWithConfigIsEmpty()
    {
        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $config = array();

        $ser = $this->TokenTypeFactory->createService($mainSm);
        $r = $ser($config, 'server3');
        $this->assertNull($r);
    }
}

